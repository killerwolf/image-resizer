<?php

$router = new \Phalcon\Mvc\Router(false);

$router->add("/", "Img::index");

$router->add("/info", "Img::index");

$router
    ->add(
        "/{transformation:(fit|pad)}/{origin}/{width:([0-9]+)}x{height:([0-9]+)}/{parameters:(.+)}/{title:([a-zA-Z0-9_-]+)}.{ext:([a-zA-Z0-9_-]+)}",
        array(
            'controller' => 'img',
            'action' => 'transform',
    ))
    ->convert('origin',function ($origin) {
        return urldecode( str_replace( '%2E','.',str_replace('.','%',$origin)));
    })
    ->convert('parameters', function ($p) {

        //parsing parameters
        $p = explode('/', $p);
        foreach ($p as $key => $value) {
            if($key%2 == 0) $pp[$value]= $p[$key+1];
        }

        //validation parameters format
        array_walk($pp,function (&$val,$key) {
            if ($key == 'crop-from' and !in_array($val, array('top','bottom','left','right'))) {$val = null;}
            if ($key == 'quality' and !is_int((int) $val)) {$val = 80;}
        });

        return $pp;
    });

return $router;

//([a-z]+/[0-9]+)+
