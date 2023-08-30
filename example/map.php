<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Example\Src\Helper;
use Restfull\Mapsapi\BaseMap;

$map = new BaseMap(key_api);
echo $map->helper(
    new Helper(),
    [
        'zoom' => 3,
        'example' => true,
        'keys' => [
            'map',
            'gestureHandling',
            'zoomControl',
            'streetViewControl',
            'coordinates',
            'infoWindows',
            'geolocationCenterMap'
        ],
        'values' => [
            'map' => ['style' => ['width' => '300px', 'height' => '238px']],
            'gestureHandling' => ['cooperative'],
            'zoomControl' => true,
            'streetViewControl' => true,
            [['-22,9068', '-43,1728'], ['-22,9219', '-43,2353']],
            [
                ['Norte Shopping', 'Av. Dom Helder Camara, 5474 - Cachambi, Rio de Janeiro - RJ, 20771-004'],
                ['Shopping Tijuca', 'Av. Maracanã, 987 - Tijuca, Rio de Janeiro - RJ, 20511-000']
            ],
            ['-22,9083', '-43,1971']
        ]
    ]
)->render('maps-javascript-api');
