<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'Core\\' => __DIR__ . '/',
        'App\\' => __DIR__ . '/../app/'
    ];
    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

