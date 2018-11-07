<?php

use Dhii\Di\ContainerAwareCachingContainer;
use Dhii\Cache\MemoryMemoizer;

/**
 * The function that bootstraps the application.
 *
 * 1. Get application routes.
 * 2. Get application services, configured using the routes.
 * 3. Create the DI container with the services, and a new in-memory service cache.
 * 4. Create a request from SAPI vars.
 * 5. Handle the request, and retrieve the response.
 * 6. Emit the response.
 *
 * @since [*next-version*]
 */
return function ($appRootPath, $appRootUrl) {

    ini_set('log_errors_max_len','0');
    $appRootDir = dirname($appRootPath);

    if (file_exists($autoload = "$appRootDir/vendor/autoload.php")) {
        require_once($autoload);
    }

    $servicesFactory = require_once("$appRootDir/services.php");
    $c = new ContainerAwareCachingContainer(
        $servicesFactory($appRootPath, $appRootUrl),
        new MemoryMemoizer()
    );

    return $c->get('plugin');
};
