<?php

$router = new \Phalcon\Mvc\Router(false);

$router->add("/", "Img::index");

$router->add("/{transformation}/{origin}/{width:([0-9]+)}x{height:([0-9]+)}/quality/{quality:([0-9]+)}/{title:([a-zA-Z0-9_-]+)}.{ext}", array(        
    'controller' => 'img',
    'action' => 'fit',
));

return $router;