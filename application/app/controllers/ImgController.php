<?php

namespace H4md1\ImageResizer\Controller;

use Imagine\Image\ImageInterface;
use Imagine\Image\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\Color;

class ImgController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->disable();
        phpinfo();
    }

    public function transformAction()
    {
        $this->view->disable();
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "image/jpg");
        $response->setHeader('Cache-Control', 'public, max-age=86400');

        $params = $this->dispatcher->getParams();

        $originContent = $this->di
                        ->getService('buzz')
                        ->resolve()
                        ->get($params['o'])
                        ->getContent();

        $imgObject = $this->di
                        ->getService('imagine')
                        ->resolve()
                        ->load($originContent)
                        ->strip();

        $imgContent = $imgObject
                        ->thumbnail(
                            new Box(
                                $params['w'],
                                $params['h']
                            ),
                            ImageInterface::THUMBNAIL_OUTBOUND
                        )->interlace(ImageInterface::INTERLACE_PLANE)
                        ->get('jpeg', ['quality' => $params['p']['quality']]);

        $response->setContent($imgContent);

        return $response;
    }

    public function errorAction()
    {

    }
}
