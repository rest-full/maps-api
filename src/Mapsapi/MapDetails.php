<?php

namespace Rustfull\Mapsjavascriptapi;

class MapDetails
{

    /**
     * @var array
     */
    private $map = [];

    /**
     * @var array
     */
    private $coordinates = [];

    /**
     * @var array
     */
    private $infoWindows = [];

    /**
     * @var array
     */
    private $geographicLocation = [];

    /**
     * @var array
     */
    private $geolocationCenterMap = [];

    /**
     * @var array
     */
    private $gestureHandling = ['cooperative'];

    /**
     * @var int
     */
    private $zoom = 0;

    /**
     * @var bool
     */
    private $zoomControl = true;

    /**
     * @var bool
     */
    private $streetViewControl = true;

    /**
     * @return mixed
     */
    public function map(array $map = null)
    {
        if (!is_null($map)) {
            $this->map = $map;
            return $this;
        }
        return $this->map;
    }

    /**
     * @return mixed
     */
    public function gestureHandling(array $gestureHandling = null)
    {
        if (!is_null($gestureHandling)) {
            if ($this->gestureHandling !== $gestureHandling) {
                $this->gestureHandling = $gestureHandling;
            }
            return $this;
        }
        return $this->gestureHandling;
    }

    /**
     * @return mixed
     */
    public function zoom(int $zoom = null)
    {
        if (!is_null($zoom)) {
            $this->zoom = $zoom;
            return $this;
        }
        return $this->zoom;
    }

    /**
     * @return mixed
     */
    public function zoomControl(bool $zoomControl = null)
    {
        if (!is_null($zoomControl)) {
            if ($this->zoomControl !== $zoomControl) {
                $this->zoomControl = $zoomControl;
            }
            return $this;
        }
        return $this->zoomControl;
    }

    /**
     * @return mixed
     */
    public function streetViewControl(bool $streetViewControl = null)
    {
        if (!is_null($streetViewControl)) {
            $this->streetViewControl = $streetViewControl;
            return $this;
        }
        return $this->streetViewControl;
    }

    /**
     * @param array $coordinate
     * @return $this
     */
    public function coordinates(array $coordinates = null): Marker
    {
        if (!is_null($coordinates)) {
            $this->coordinates = $coordinates;
            return $this;
        }
        return $this->coordinates;
    }

    /**
     * @param array $coordinate
     * @return $this
     */
    public function geolocationCenterMap(array $geolocationCenterMap = null): Marker
    {
        if (!is_null($geolocationCenterMap)) {
            $this->geolocationCenterMap = $geolocationCenterMap;
            return $this;
        }
        return $this->geolocationCenterMap;
    }

    /**
     * @param array $coordinate
     * @return $this
     */
    public function geographicLocation(array $geographicLocation = null): Marker
    {
        if (!is_null($geographicLocation)) {
            $this->geographicLocation = $geographicLocation;
            return $this;
        }
        return $this->geographicLocation;
    }

    /**
     * @param array $info
     * @return Marker
     */
    public function infoWindows(array $infoWindows = null): Marker
    {
        if (!is_null($infoWindows)) {
            $this->infoWindows = $infoWindows;
            return $this;
        }
        return $this->infoWindows;
    }

    /**
     * @return mixed
     */
    public function others(array $others = null)
    {
        if (!is_null($others)) {
            $this->others = $others;
            return $this;
        }
        return $this->others;
    }

}
