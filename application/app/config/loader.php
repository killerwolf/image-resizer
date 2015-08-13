<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->modelsDir
    )
);

$loader->registerNamespaces(
    array(
        'H4md1\ImageResizer\Controller' => $config->application->controllersDir,
    )
);

$loader->register();
