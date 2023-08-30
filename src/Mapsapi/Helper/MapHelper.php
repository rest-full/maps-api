<?php

namespace Restfull\Mapsapi\Helper;

use Restfull\Mapsapi\BaseMap;

/**
 *
 */
class MapHelper
{

    /**
     * @var Object
     */
    private $helper;

    /**
     * @var array
     */
    private $template
        = [
            'div' => '<div id="map_canvas"></div>',
            'link' => '<script Src="%s" type="%s"></script>',
            'block' => '<script>%s</script>'
        ];

    /**
     * @var BaseMap
     */
    private $map;

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var array
     */
    private $script = [];

    /**
     * @param object $helper
     * @param BaseMap $map
     */
    public function __construct(object $helper, BaseMap $map)
    {
        $this->helper = $helper;
        $this->helper->template($this->template);
        $this->map = $map;
        return $this;
    }

    /**
     * @return object
     */
    public function scriptMaker(): MapHelper
    {
        $this->scriptsBase('maker')->scriptsMap()->scriptsMaker()->scriptsInfoWindow();
        return $this;
    }

    /**
     * @return object
     */
    private function scriptsInfoWindow(): MapHelper
    {
        $script[] = ['text' => 'if (infoWindows.length > 0) {', 'sprintf' => []];
        $script[] = ['text' => 'infoWindow = new google.maps.InfoWindow();', 'sprintf' => []];
        $script[] = ['text' => 'content = infoWindows[i].unidade;', 'sprintf' => []];
        $script[] = [
            'text' => 'google.maps.event.addListener(marker, "click", (function (marker, content, infoWindow) {',
            'sprintf' => []
        ];
        $script[] = ['text' => 'return function () {', 'sprintf' => []];
        $script[] = ['text' => 'infoWindow.setContent(content);', 'sprintf' => []];
        $script[] = ['text' => 'infoWindow.open(map, marker);', 'sprintf' => []];
        $script[] = ['text' => '});', 'sprintf' => []];
        $script[] = ['text' => '})(marker, content, infoWindow));', 'sprintf' => []];
        $script[] = ['text' => '}}}};', 'sprintf' => []];
        $this->scriptConvert($script);
        return $this;
    }

    /**
     * @return object
     */
    private function scriptConvert(array $script): MapHelper
    {
        for ($a = 0; $a < count($script); $a++) {
            if (count($script[$a]['sprintf']) > 0) {
                foreach ($script[$a]['sprintf'] as $key => $value) {
                    if (in_array($key, ['geolocationCenterMap', 'infoWindows', 'origins', 'destinations']
                        ) !== false) {
                        if (in_array($key, ['geolocationCenterMap', 'infoWindows']) !== false) {
                            $newValue = json_encode($this->map->options($key), JSON_FORCE_OBJECT);
                        } elseif (in_array($key, ['origins', 'destinations']) !== false) {
                            $newValue = json_encode($this->map->options($key), JSON_FORCE_OBJECT);
                        }
                    } else {
                        $newValue = $this->map->options($key);
                    }
                    if (!empty($value)) {
                        $newValue = $newValue[$value];
                    }
                    $text = sprintf($script[$a]['text'], $newValue);
                }
                $script[$a] = $text;
            } else {
                $script[$a] = $script[$a]['text'];
            }
        }
        $this->script = count($this->script) > 0 ? array_merge($this->script, $script) : $script;
        return $this;
    }

    /**
     * @return object
     */
    private function scriptsMaker(): MapHelper
    {
        $script[] = ['text' => 'if (geolocations.length > 0) {', 'sprintf' => []];
        $script[] = ['text' => 'for (var i = 0; i < geolocations.length; i++) {', 'sprintf' => []];
        $script[] = ['text' => 'marker = new google.maps.Marker({', 'sprintf' => []];
        $script[] = ['text' => 'position: geolocations[i],', 'sprintf' => []];
        $script[] = ['text' => 'map: map', 'sprintf' => []];
        $script[] = ['text' => '});', 'sprintf' => []];
        $script[] = ['text' => 'map.setCenter(marker.getPosition());', 'sprintf' => []];
        $this->scriptConvert($script);
        return $this;
    }

    /**
     * @return object
     */
    private function scriptsMap(): MapHelper
    {
        $script[] = ['text' => 'map = new google.maps.Map(divMap, {', 'sprintf' => []];
        $script[] = ['text' => 'zoom: ', 'sprintf' => ['zoom' => '']];
        $script[] = ['text' => 'center: {lat: %s, lng: %s},', 'sprintf' => ['geolocationCenterMap' => '']];
        $script[] = ['text' => 'zoomControl: %s,', 'sprintf' => ['options' => 'zoom']];
        $script[] = ['text' => 'streetViewControl: %s,', 'sprintf' => ['options' => 'street']];
        $script[] = ['text' => 'mapTypeId: google.maps.MapTypeId.ROADMAP', 'sprintf' => []];
        $script[] = ['text' => '});', 'sprintf' => []];
        $this->scriptConvert($script);
        return $this;
    }

    /**
     * @return object
     */
    private function scriptsBase(string $type): MapHelper
    {
        $script = [];
        $script[] = ['text' => 'var map, divMap = document.getElementById("map_canvas");', 'sprintf' => []];
        $script[] = ['text' => 'divMap.style.width = "%s";', 'sprintf' => ['options' => 'width']];
        $script[] = ['text' => 'divMap.style.height = "%s";', 'sprintf' => ['options' => 'height']];
        $script[] = ['text' => 'divMap.style.borderRadius = "%s";', 'sprintf' => ['options' => 'borderRadius']];
        $script[] = ['text' => 'divMap.style.margin = "%s";', 'sprintf' => ['options' => 'margin']];
        if ($type === 'maker') {
            $script[0]['text'] = str_replace(
                    ';',
                    ', ',
                    $script[0]['text']
                ) . ' geolocations, infoWindows, infoWindow, maker, content;';
            $script[] = ['text' => 'geolocations = Object.values(%s);', 'sprintf' => ['geographicLocation' => '']];
            $script[] = ['text' => 'infoWindows = Object.values(%s);', 'sprintf' => ['infoWindows' => '']];
            $script[] = ['text' => 'initMap(divMap, geolocations, infoWindows);', 'sprintf' => []];
            $script[] = ['text' => 'function initMap(divMap, geolocations, infoWindows) {', 'sprintf' => []];
        } elseif ($type === 'direction') {
            $script[0]['text'] = str_replace(
                    ';',
                    ', ',
                    $script[0]['text']
                ) . ' service, renderer, waypoints;';
            $script[] = ['text' => 'service = new google.maps.DirectionsService()', 'sprintf' => []];
            $script[] = ['text' => 'renderer = new google.maps.DirectionsRenderer()', 'sprintf' => []];
            $script[] = ['text' => 'waypoints = Object.values(%s);', 'sprintf' => ['waypoint' => '']];
            $script[] = [
                'text' => 'initMap(divMap, origins, destinations, service, renderer, waypoints);',
                'sprintf' => []
            ];
            $script[] = [
                'text' => 'function initMap(divMap, origins, destinations, service, renderer, waypoints) {',
                'sprintf' => []
            ];
        }
        $this->scriptConvert($script);
        return $this;
    }

    /**
     * @return object
     */
    public function scriptDistance(): MapHelper
    {
        $this->scriptsBase('distance')->scriptsMap()->scriptsDistance();
        return $this;
    }

    /**
     * @return object
     */
    public function scriptDiraction(): MapHelper
    {
        $this->scriptsBase('diraction')->scriptsMap()->scriptsDirection();
        return $this;
    }

    private function scriptsDirection(): MapHelper
    {
        $script[] = ['text' => 'var datas = {}', 'sprintf' => []];
        $script[] = ['text' => 'if (waypoints.length > 0) {', 'sprintf' => []];
        $script[] = ['text' => 'datas = {waypoints: waypoints, optimizeWaypoints: true};', 'sprintf' => []];
        $script[] = ['text' => '}', 'sprintf' => []];
        $script[] = ['text' => 'renderer.set(map);', 'sprintf' => []];
        $script[] = ['text' => 'service.route(Object.assign(datas,{', 'sprintf' => []];
        $script[] = ['text' => 'origin: origins[0], destinations: destinations[0],', 'sprintf' => []];
        $script[] = ['text' => 'travelMode: google.maps.TravelMode[%s]', 'sprintf' => ['mode' => '']];
        $script[] = ['text' => 'avoidHighways: %s', 'sprintf' => ['haghways' => '']];
        $script[] = ['text' => 'avoidTolls: %s', 'sprintf' => ['tolls' => '']];
        $script[] = ['text' => '}),function(response, status) {', 'sprintf' => []];
        $script[] = ['text' => 'if (status === "OK") {', 'sprintf' => []];
        $script[] = ['text' => 'renderer.setDirections(response);', 'sprintf' => []];
        $script[] = ['text' => '}else{', 'sprintf' => []];
        $script[] = ['text' => 'alert("Direction failed.");', 'sprintf' => []];
        $script[] = ['text' => '}', 'sprintf' => []];
        $script[] = ['text' => '});', 'sprintf' => []];
        $script[] = ['text' => '}', 'sprintf' => []];
        $this->scriptConvert($script);
        return $this;
    }

    /**
     * @param string $base
     *
     * @return string
     */
    public function render(string $file, string $path = ''): string
    {
        return $this->template['div'] . PHP_EOL . $this->helper->formatTemplate(
                $this->template['link'],
                [URL . $path . $this->file, 'type/javascript']
            ) . PHP_EOL . $this->helper->formatTemplate($this->template['block'], [implode(PHP_EOL, $this->script)]);
    }

}
