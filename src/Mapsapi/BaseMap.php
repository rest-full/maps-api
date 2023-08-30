<?php

namespace Restfull\Mapsapi;

use Restfull\Error\Exceptions;
use Restfull\Mapsapi\Component\MapComponent;

/**
 *
 */
class BaseMap extends Map
{

    /**
     *
     */
    public function __construct(string $key)
    {
        parent::__construct($key);
        return $this;
    }

    /**
     * @param object $component
     * @param string $method
     *
     * @return array
     * @throws Exceptions
     */
    public function component(object $component, string $method = ''): MapComponent
    {
        $this->instance($component);
        $component = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Mapsjavascriptapi' . DS_REVERSE . 'Component' . DS_REVERSE . 'MapComponent',
                ['Restfull']
            ),
            ['component' => $component, 'map' => $this]
        );
        if (!empty($method)) {
            if (in_array($method, ['distance', 'diraction', 'coordenate']) === false) {
                throw new Exceptions('There is no other api map method besides coordinates, distance and direction.', 404);
            }
            $component->{$method}();
        }
        return $component;
    }

    /**
     * @param object $class
     *
     * @return mixed
     */
    public function instance(object $class = null)
    {
        if (!is_null($class)) {
            $this->instance = $class->instance();
            return $this;
        }
        return $this->instance;
    }

    /**
     * @param object $helper
     * @param string $path
     *
     * @return string
     * @throws Exceptions
     */
    public function helper(object $helper, array $options, string $method = ''): MapHelper
    {
        $this->instance($helper);
        $file = $this->zoomAndFileJs($options['zoom'] ?? 5, $options['example'] ?? false);
        if (isset($options['keys'], $options['values'])) {
            $this->options($options['keys'], $options['values']);
        }
        $helper = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Mapsjavascriptapi' . DS_REVERSE . 'Helper' . DS_REVERSE . 'MapHelper',
                ['Restfull']
            ),
            ['helper' => $helper, 'map' => $this]
        );
        if (!empty($method)) {
            if ($method === 'scriptDistance') {
                throw new Exceptions('There is no script to render map other than direction and marking.', 404);
            }
            $helper->{$method}();
        }
        return $helper;
    }

    /**
     * @param object $object
     * @param string $method
     * @return $this
     * @throws Exceptions
     */
    public function executeMethod(object $object, string $method): BaseMap
    {
        if ($method === 'scriptDistance') {
            throw new Exceptions('There is no script to render map other than direction and marking.', 404);
        } elseif (in_array($method, ['distance', 'diraction', 'coordenation']) === false) {
            throw new Exceptions('There is no other api map method besides coordinates, distance and direction.', 404);
        }
        $object->{$method}();
        return $this;
    }

}
