<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Example\Src\Component;
use Restfull\Mapsapi\BaseMap;
use Restfull\Mapsapi\Component\MapComponent;

$map = new BaseMap(key_api);
$map->setGeolocation(
    [
        'address' => 'Av. Dom Helder Camara',
        'number' => '5474',
        'district' => 'Cachambi',
        'city' => 'Rio de Janeiro',
        'state' => 'RJ',
        'zipcode' => '20771-004'
    ]
);
print_r($map->component(new MapComponent(),'coordenation')->returnJson());
