<?php

namespace Restfull\Mapsapi;

use MatthiasMullie\Minify\JS;
use Restfull\Container\Instances;
use Restfull\Error\Exceptions;
use Rustfull\Mapsjavascriptapi\MapDetails;

/**
 *
 */
class Map
{

    /**
     * @var MapApi
     */
    protected $api;

    /**
     * @var string
     */
    protected $url = 'https://maps.googleapis.com/maps/api/%s/json';

    /**
     * @var Distances
     */
    private $distances;

    /**
     * @var Geolocation
     */
    private $geographicLocation;

    /**
     * @var MapDetails
     */
    private $details;

    /**
     * @var string
     */
    private $key = '';

    /**
     * @var Instances
     */
    private $instance;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @param array $address
     * @param string $mode
     * @param array $waypoint
     * @return object
     */
    public function distance(array $address = null, string $mode = 'driving', array $waypoint = []): Map
    {
        if (!is_null($address)) {
            $this->api = new MapApi();
            $this->api->address('distancematrix', $address)->mode($mode);
            if (count($waypoint) > 0) {
                for ($a = 0; $a < count($waypoint); $a++) {
                    $this->api->waypoint($waypoint[$a], !((count($waypoint) - 1) === $a));
                }
            }
        }
        return $this;
    }

    /**
     * @param array $address
     * @return object
     */
    public function direction(array $address = null): Map
    {
        if (!is_null($address)) {
            $this->api = new MapApi();
            $this->api->address('direction', $address);
        }
        return $this;
    }

    /**
     * @param array|null $address
     * @return object
     */
    public function geographicLocation(array $address = null): Map
    {
        if (!is_null($address)) {
            $this->api = new MapApi();
            $this->api->address('geographicLocation', [$address]);
        }
        return $this;
    }

    public function api(string $method, $type = '')
    {
        if (!empty($type)) {
            return $this->api->{$method}($type);
        }
        return $this->api->{$method}();
    }

    /**
     * @return object
     */
    public function changeUrl(): Map
    {
        $this->url = 'https://maps.googleapis.com/maps/api/js';
        return $this;
    }

    /**
     * @param int $zoom
     * @param bool $example
     * @return string
     * @throws Exceptions
     */
    protected function zoomAndFileJs(int $zoom, bool $example)
    {
        $file = $example ? ROOT . 'example' . DS . 'webroot' : ROOT . 'webroot';
        $file .= DS . 'js' . DS . 'map.js';
        $this->options(['zoom'], [$zoom]);
        $js = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath('%s' . DS_REVERSE . 'Search' . DS_REVERSE . 'Search', ['Restfull']),
            ['uri' => $this->url()->url]
        );
        $js->searching(['CURLOPT_TIMEOUT' => 3], 'key=' . $this->key);
        (new JS())->add(trim($js->answer()))->minify($file);
        @unlink($file);
        return $file;
    }

    /**
     * @param array $keys
     * @param array|null $values
     * @return mixed
     * @throws Exceptions
     */
    public function options(array $keys, array $values = null)
    {
        if ($this->details instanceof MapDetails) {
            $this->details = $this->instance->resolveClass(
                $this->instance->assemblyClassOrPath(
                    '%s' . DS_REVERSE . 'Mapsjavascriptapi' . DS_REVERSE . 'MapDetails',
                    ['Restfull']
                )
            );
        }
        if (is_null($values)) {
            $count = count($keys);
            for ($a = 0; $a < $count; $a++) {
                $method = ucfirst($keys[$a]);
                $this->details->{$method}($this->tratament($values[$a], $keys[$a]));
            }
            return $this;
        }
        $method = ucfirst($keys[0]);
        return $this->details->{$method}();
    }

    /**
     * @param mixed $datas
     * @param string $key
     * @return array|mixed
     */
    private function tratament($datas, string $key)
    {
        if (in_array($key, ['coordenates', 'geolocationCenterMap', 'infoWindows']) !== false) {
            $newDatas = [];
            if (in_array($key, ['coordenates', 'geolocationCenterMap']) !== false) {
                foreach ($datas as $name => $data) {
                    if (!is_string($name)) {
                        $name = $name === 0 ? 'latitude' : 'longitude';
                    }
                    $newDatas[$name === 'latitude' ? 'lat' : 'lng'] = $data;
                }
                return $newDatas;
            }
            foreach ($datas as $name => $data) {
                $newDatas[] = ['unidade' => '<b>' . $data[0] . '</b><p>' . $data[1] . '</p>'];
            }
            return $newDatas;
        }
        return $datas;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

}