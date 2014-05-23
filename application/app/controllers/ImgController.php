<?php

use Buzz\Exception\ClientException;

use Imagine\Image\ImageInterface,
    Imagine\Image\Image,
    Imagine\Image\Box,
    Imagine\Image\Point,
    Imagine\Image\Color;

class ImgController extends \ControllerBase
{

    public function indexAction()
    {
		echo 'index';
    }

    public function fitAction()
    {
    	$response = new \Phalcon\Http\Response();
    	$response->setHeader("Content-Type", "image/jpg");

    	$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);

    	$params = $this->dispatcher->getParams();
		//var_dump($params);

		$originUriDecoded = $this->di->getService('originUriDecode')->resolve(array($params['origin']));
		//var_dump($originUriDecoded);

		$imagine = $this->di->getService('imagine')->resolve();
		$thumb = $imagine->open($originUriDecoded)
    		->thumbnail(
    			new Box($params['width'], $params['height']), 
    			Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
			)
    	;
    	$response->setContent($thumb);
return $response;

    }

    public function padAction()
    {
		echo 'fit';
    }
}

