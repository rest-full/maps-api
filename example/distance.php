<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Example\Src\Component;
use Restfull\Mapsapi\BaseMap;
use Restfull\Mapsapi\Component\MapComponent;

$map = new BaseMap(key_api, 5, true);
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
print_r($distance$map->component(new Component(),'distance')->restunJson());
