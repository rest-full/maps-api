<?php

namespace Restfull\Mapsapi;

class MapApi
{

    /**
     * @var array
     */
    private $returnJson = [];

    /**
     * @var array
     */
    private $address = [];

    /**
     * @var array
     */
    private $waypoints = [];

    /**
     * @var string
     */
    private $api = '';

    /**
     * @var string
     */
    private $mode = 'driving';

    /**
     * @param array $address
     * @return $this
     */
    public function address(string $mode, array $address): MapApi
    {
        $keys = $mode === 'geographicLocation' ? ['location'] : ['destination', 'origin'];
        $count = count($keys);
        for ($a = 0; $a < $count; $a++) {
            if (in_array('complement', array_keys($address[$a])) !== false) {
                throw new Exception('Cannot contain the complement in this array');
            }
            foreach (['address', 'number', 'district', 'city', 'state', 'zipcode'] as $key) {
                if (!empty($address[$a][$key])) {
                    $newAddress[] = $address[$a][$key];
                    if (in_array($key, ['address', 'number', 'district', 'city', 'state']) !== false) {
                        $newAddress[count($newAddress) - 1] .= in_array($key, ['address', 'district', 'state']
                        ) !== false ? ', ' : ' - ';
                    }
                }
            }
            $this->address[$keys[$a]] = urlencode(implode('', $newAddress));
        }
        $this->api = $mode;
        return $this;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        if ($this->api === 'geographicLocation') {
            return 'address=' . $this->address['location'];
        }
        $url = 'origin=' . $this->address['origin'] . '&destination=' . $this->address['destination'];
        if ($this->api === 'distancematrix') {
            $keys = ['mode'];
            if (count($this->waypoints) > 0) {
                $keys = array_merge($keys, ['waypoint']);
            }
            foreach ($keys as $key) {
                $data = '';
                if ($key === 'waypoint') {
                    $data = 'optinize:true|';
                    $this->waypoints = implode('|', $this->waypoints);
                }
                $url .= $key . '=' . $data . $this->{$key};
            }
        }
        return $url;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function mode(string $mode): MapApi
    {
        if (in_array($mode, ['driving', 'walking', 'bicycling', 'transit']) === false) {
            throw new Exceptions();
        }
        if ($this->mode !== $mode) {
            $this->mode = $mode;
        }
        return $this;
    }

    /**
     * @param array $waypoint
     * @return $this
     */
    public function waypoint(string $waypoint): MapApi
    {
        $this->waypoint = $waypoint;
        return $this;
    }

    /**
     * @param array|null $returnJson
     * @return mixed
     */
    public function returnJson(array $returnJson = null)
    {
        if (!is_null($returnJson)) {
            $this->returnJson = $returnJson;
            return $this;
        }
        return $this->returnJson;
    }

}