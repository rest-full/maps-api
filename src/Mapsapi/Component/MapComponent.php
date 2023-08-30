<?php

namespace Restfull\Mapsapi\Component;

use Restfull\Container\Instances;
use Restfull\Mapsapi\BaseMap;

/**
 *
 */
class MapComponent
{

    /**
     * @var Object
     */
    private $component;

    /**
     * @var BaseMap
     */
    private $map;

    /**
     * @var Instances
     */
    private $instance;

    /**
     * @param BaseMap $map
     */
    public function __construct(object $component, BaseMap $map)
    {
        $this->component = $component;
        $this->map = $map;
        $this->instance = $map->instance();
        return $this;
    }

    /**
     * @return BaseMap
     */
    public function coordenation(): BaseMap
    {
        $geolocation = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Search' . DS_REVERSE . 'Search',
                ['Restfull']
            ),
            ['uri' => $this->instance->assemblyClassOrPath($this->map->url(), ['geocode'])]
        );
        $geolocation = json_decode(
            $geolocation->searching(['CURLOPT_FOLLOWLOCATION' => true],
                'key=' . $this->map->key() . '&' . $this->map->api('url'))->answer(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );
        $this->map->api(
            'returnJson',
            [$geolocation->results[0]->geometry->location->lat, $geolocation->results[0]->geometry->location->lng]
        );
        return $this->map;
    }

    /**
     * @return BaseMap
     */
    public function direction(): BaseMap
    {
        $direction = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Search' . DS_REVERSE . 'Search',
                ['Restfull']
            ),
            ['uri' => $this->instance->assemblyClassOrPath($this->map->url(), ['distance'])]
        );
        $direction = json_decode(
            $direction->searching(['CURLOPT_FOLLOWLOCATION' => true],
                'key=' . $this->map->key() . '&' . $this->map->api('url', 'distance'))->answer(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );
        $route = $direction->route[0]->legs[0];
        $duration = $route->duration->text . ' - ' . $route->distance->text;
        $steps = $route->steps;
        $itinerary = [];
        for ($a = 0; $a < count($steps); $a++) {
            $itinerary[] = $steps[$a]->html_instructions;
        }
        $this->map->api('returnJson', ['dureation' => $duration, 'intinerary' => $itinerary]);
        return $this->map;
    }

    /**
     * @return BaseMap
     */
    public function distance(): BaseMap
    {
        $distance = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Search' . DS_REVERSE . 'Search',
                ['Restfull']
            ),
            ['uri' => $this->instance->assemblyClassOrPath($this->map->url(), ['distancematrix'])]
        );
        $distance = json_decode(
            $distance->searching(['CURLOPT_FOLLOWLOCATION' => true],
                'key=' . $this->map->key() . '&' . $this->map->api('url', 'distancematrix'))->answer(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );
        $this->map->api('returnJson', [$distance->rows[0]->elements[0]]);
        return $this->map;
    }
}
