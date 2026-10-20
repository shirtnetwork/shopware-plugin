<?php declare(strict_types=1);

require dirname(__DIR__, 4) . '/vendor/autoload.php';

date_default_timezone_set('UTC');

spl_autoload_register(static function (string $class): void {
    $prefix = 'Aggrosoft\\Shopware\\ShirtnetworkPlugin\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $path = dirname(__DIR__) . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($path)) {
        require $path;
    }
});
