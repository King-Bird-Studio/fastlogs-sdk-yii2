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
            "url": "https://github.com/King-Bird-Studio/fastlogs-sdk-php.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/King-Bird-Studio/fastlogs-sdk-yii2.git"
        },
    ],
    .....
}
```
2. Подключить к проекту:
```bash
composer require fastlogs/yii2-sdk:dev-main
```

3. Добавьте целевой класс в конфигурацию приложения:

```php
return [
    'components' => [
	    'log' => [
		    'traceLevel' => YII_DEBUG ? 3 : 0,
		    'targets' => [
                [
                    'class' => 'fastlogsYii\FastlogsTarget',
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
use  fastlogsYii\Fastlogs;

$data = [123, 456, 'sldfkjsf'];
Fastlogs::add($data, 'jQpUFtifBZ');
```
