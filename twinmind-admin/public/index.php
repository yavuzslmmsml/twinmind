<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $path = __DIR__ . '/../' . $class . '.php';

    if (file_exists($path)) {
        require_once $path;
        return;
    }
});

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../routes/web.php';

\Core\Router::dispatch();
