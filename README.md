    <p align="center">
        <h1 align="center">Fastlogs Yii2</h1>
        <br>
    </p>

Требования
------------

PHP 5.6+, установленные расширения json и curl.

Установка
---------------

1. Добавить в composer.json репозиторий:
```bash
{
    ....
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:King-Bird-Studio/fastlogs-sdk-yii2.git"
        }
    ],
    .....
}
```
2. Подключить к проекту:
```bash
composer require "fastlog/yii2-sdk:master-dev"
```

3. Добавьте целевой класс в конфигурацию приложения:

```php
return [
    'components' => [
	    'log' => [
		    'traceLevel' => YII_DEBUG ? 3 : 0,
		    'targets' => [
                [
                    'class' => 'fastlog\FastlogTarget',
                    'levels' => ['error', 'warning'],
                    'slug' => 'You slug fastlog',
                ],
		    ],
	    ],
    ],
];
```

Использование
------------

Если нужно писать в отдельный лог:

```php
use  fastlog\Fastlog;

$data = [123, 456, 'sldfkjsf'];
Fastlog::add($data, 'jQpUFtifBZ');
```
