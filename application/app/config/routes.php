<?php

$router = new \Phalcon\Mvc\Router(false);

$router->add("/info", "H4md1\\ImageResizer\\Controller\\Img::index");

//$router->add("/info", "Img::index");

$router
    ->add(
        "/{t:(fit|pad)}/{o}/{w:([0-9]+)}x{h:([0-9]+)}/{p:(.+)}/{title:([a-zA-Z0-9_-]+)}.{e:([a-zA-Z0-9_-]+)}",
        array(
            'namespace' => 'H4md1\\ImageResizer\\Controller',
            'controller' => 'Img',
            'action' => 'transform',
        )
    )
        ->convert('o', function ($origin) {
            return urldecode(str_replace('%2E', '.', str_replace('.', '%', $origin)));
        })
    ->convert('p', function ($p) {

        //parsing parameters
        $p = explode('/', $p);
        $pp = [];
        foreach ($p as $key => $value) {
            if ($key%2 == 0) {
                $pp[$value]= $p[$key+1];
            }
        }

        //validation parameters format
        array_walk($pp, function (&$val, $key) {
            if ($key == 'crop-from' and !in_array($val, array('top','bottom','left','right'))) {
                $val = null;
            }
            if ($key == 'quality' and !is_int((int) $val)) {
                $val = 80;
            }
        });

        return $pp;
    });

return $router;

//([a-z]+/[0-9]+)+
