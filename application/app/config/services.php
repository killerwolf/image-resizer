<?php

use Phalcon\DI;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

$di = new DI();

$di->set('dispatcher', function () {
    return new MvcDispatcher();

}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

$di->set('router', function () {
    require __DIR__.'/routes.php';

    return $router;
});

$di->set('originUriDecode', function ($data) {
    return urldecode(
        str_replace(
            '%2E',
            '.',
            str_replace(
                '.',
                '%',
                $data
            )
        )
    );
});

$di->set('imagine', function () {
    if (class_exists('\Gmagick')) {
            $drv = 'Gmagick';
        } elseif (class_exists('\Imagick')) {
            $drv = 'Imagick';
        } else {
            $drv = 'Gd';
        }
        $className = sprintf('Imagine\%s\Imagine',$drv );

    return new $className;
},true);

$di->set('response', 'Phalcon\Http\Response');

$di->set('buzz',function () {
    $c = new \Buzz\Client\Curl();
    $c->setTimeout(999);

    return new \Buzz\Browser($c);
});
