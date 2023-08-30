<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Example\Src\Component;
use Restfull\Mapsapi\Component\MapComponent;
use Restfull\Mapsapi\BaseMap;

$map = new BaseMap(key_api);
$map->distance(
    [
        [
            'address' => 'Av. Dom Helder Camara',
            'number' => '6726',
            'district' => 'Cachambi',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'zipcode' => '20771-005'
        ],
        [
            'address' => 'Av. Dom Helder Camara',
            'number' => '6713',
            'district' => 'Cachambi',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'zipcode' => '20771-002'
        ]
    ],
    'bike'
);
print_r($map->component(new MapComponent(),'direction')->resturnJson());
