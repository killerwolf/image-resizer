<?php

use Imagine\Image\ImageInterface,
    Imagine\Image\Image,
    Imagine\Image\Box,
    Imagine\Image\Point,
    Imagine\Image\Color;

class ImgController extends \ControllerBase
{

    public function indexAction()
    {
        phpinfo();die();
		echo 'index';
    }

    public function fitAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
    	$response = new \Phalcon\Http\Response();
    	$response->setHeader("Content-Type", "image/jpg");
        $response->setHeader('Cache-Control', 'public, max-age=86400');
    	
    	$params = $this->dispatcher->getParams();

        $originContent = $this->di
                        ->getService('guzzle')
                        ->resolve()
                        ->get($params['origin'])
                        ->getBody();

		$imgContent = $this->di
                        ->getService('imagine')
                        ->resolve()
                        ->load($originContent)
                        ->strip()
                        ->thumbnail(
                            new Box(
                                $params['width'], 
                                $params['height']
                            ),
                            Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
                        )->interlace(ImageInterface::INTERLACE_PLANE)
                        ->get('jpeg',['quality' => $params['parameters']['quality']]);

        $response->setContent($imgContent);
        return $response;
    }
}

