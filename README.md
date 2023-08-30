# Maps-javascript-api

## About Maps-javascript-api

An easy way to interact with the main features of Google Maps Api.

## Installation

* Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
* Run `php composer.phar require rest-full/maps-javascript-api` or composer installed globally `compser require rest-full/maps-javascript-api` or composer.json `"rest-full/maps-javascript-api": "1.0.0"` and install or update.

## Usage

The geolocation:
 ```php
 <?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Restfull\GoogleMap\Map;
use Restfull\Mapjavasciptapi\Component\MapComponent;
use Example\Src\Component;

$map = new Map(key_api, 5, true);
$map->setGeolocation(
    [
        'address' => 'Av. Dom Helder Camara', 'number' => '5474',
        'district' => 'Cachambi', 'city' => 'Rio de Janeiro', 'state' => 'RJ',
        'zipcode' => '20771-004'
    ]
);
print_r((new MapComponent(new Component(), $map))->coordenation());
```

the distance:
```php
<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Restfull\GoogleMap\Map;
use Restfull\Mapjavasciptapi\Component\MapComponent;
use Example\Src\Component;

$map = new Map(key_api, 5, true);
$map->setDistance(
    [
        [
            'address' => 'Av. Dom Helder Camara', 'number' => '6726',
            'district' => 'Cachambi', 'city' => 'Rio de Janeiro',
            'state' => 'RJ', 'zipcode' => '20771-005'
        ], [
        'address' => 'Av. Dom Helder Camara', 'number' => '6713',
        'district' => 'Cachambi', 'city' => 'Rio de Janeiro', 'state' => 'RJ',
        'zipcode' => '20771-002'
    ]
    ], 'bike'
);
print_r((new MapComponent(new Component(), $map))->distance());
```

The direction distance:
```php
<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Restfull\GoogleMap\Map;
use Restfull\Mapjavasciptapi\Component\MapComponent;
use Example\Src\Component;

$map = new Map(key_api, 5, true);
$map->setDistance(
    [
        [
            'address' => 'Av. Dom Helder Camara', 'number' => '6726',
            'district' => 'Cachambi', 'city' => 'Rio de Janeiro',
            'state' => 'RJ', 'zipcode' => '20771-005'
        ], [
        'address' => 'Av. Dom Helder Camara', 'number' => '6713',
        'district' => 'Cachambi', 'city' => 'Rio de Janeiro', 'state' => 'RJ',
        'zipcode' => '20771-002'
    ]
    ], 'bike'
);
print_r((new MapComponent(new Component(), $map))->direction());
```

Render google map with javascript:

```php
<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/pathServer.php';

use Restfull\GoogleMap\Map;
use Restfull\Mapjavasciptapi\Helper\MapHelper;
use Example\Src\Helper;

$map = new Map(key_api, 5, true);
$map->setGeolocationCenterMap(-22,9083, -43,1971)->setMarker(
        [
            'coordinates' => [
                [-22,9068, -43,1728],
                [-22,9219, -43,2353]
            ],
            'infoWindows' => [
                ['Norte Shopping', 'Av. Dom Helder Camara, 5474 - Cachambi, Rio de Janeiro - RJ, 20771-004'],
                ['Shopping Tijuca', 'Av. Maracanã, 987 - Tijuca, Rio de Janeiro - RJ, 20511-000']
            ]
        ]
);
echo (new MapHelper(new Helper(), $map))->render('maps-javascript-api');
```

## License

The maps-jacascript-api is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
 
