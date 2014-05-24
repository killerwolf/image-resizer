<?php

$router = new \Phalcon\Mvc\Router(false);

$router->add("/", "Img::index");

$router
    ->add(
    	"/{transformation}/{origin}/{width:([0-9]+)}x{height:([0-9]+)}/{parameters:([a-z\-]+\/[0-9]+)+}/{title:([a-zA-Z0-9_-]+)}.{ext}", 
    	array(        
    		'controller' => 'img',
    		'action' => 'fit',
	))
	->convert('origin',function($origin){
		return urldecode( str_replace( '%2E','.',str_replace('.','%',$origin)));
	})
	->convert('parameters', function($p){
		$p = explode('/', $p);
		
		foreach ($p as $key => $value) {
			if($key%2 == 0) $pp[$value]= $p[$key+1];
		}
		return $pp;
	});

return $router;

//([a-z]+/[0-9]+)+