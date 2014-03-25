<?php

namespace Res\FrontendBundle\Twig\Extension;

use Res\EventBundle\Entity\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InterfaceExtension extends CustomTwigExtension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array('getSizeImage' => new \Twig_Function_Method($this, 'getSizeImage'),
                     'getEventImg' => new \Twig_Function_Method($this, 'getEventImg'),
                     'getEventImgs' => new \Twig_Function_Method($this, 'getEventImgs'),
                     'getEventImgBox' => new \Twig_Function_Method($this, 'getEventImgBox'),
                     'getEventImgBoxW' => new \Twig_Function_Method($this, 'getEventImgBoxW'),
                     'getEventImgsDetail' => new \Twig_Function_Method($this, 'getEventImgsDetail'),
                     'getEventImgDetailThumbnail' => new \Twig_Function_Method($this, 'getEventImgDetailThumbnail')
        );
    }

    public function staticCall($class, $function, $args = array())
    {
        if (class_exists($class) && method_exists($class, $function)) {
            return call_user_func_array(array($class, $function), $args);
        }

        return null;
    }

    public static function getSizeImage($imgPath, $key)
    {
        $path =  "/var/www/res/web/";
        $size = @getimagesize($path.$imgPath);
    
        return $size[$key];
    }

    public function getName()
    {
        return 'interface_extension';
    }

    public function getEventImg(Event $event)
    {
        $route = \Res\ImageBundle\Entity\Image::DEFAULT_IMG;
        if (count($event->getImages()) > 0) {
            $route = $event->getImages()->first()->getWebFilePath();
        }

        return $route;
    }

    public function getEventImgs(Event $event)
    {
        if (count($event->getImages()) > 0) {
            foreach($event->getImages() as $i){
                $result = $i->getDeletedDate();
                if(!empty($result)){
                    $route[] = $i->getWebFilePath();
                }
            }
        }else{
            $route[] = \Res\ImageBundle\Entity\Image::DEFAULT_IMG;
        }
        return $route;
    } 

    public function getEventImgBox(Event $event)
    {
        $route = \Res\ImageBundle\Entity\Image::DEFAULT_IMG;
        if (count($event->getImages()) > 0) {
            if ($event->getImageMain()) {
                $image = $event->getImageMain();
                if(!$image->getDeletedDate()){
                    return $image->getImageEventBox()->getWebFilePath();
                }
            } else {
                $images = $event->getImages();
                foreach($images as $image){
                    if (!$image->getDeletedDate()) {
                        return $image->getEventEventBox()->getWebFilePath();
                    }
                }
            }
        }
        return $route;
    }

    public function getEventImgBoxW(Event $event)
    {
        $route = \Cornerfy\ImageBundle\Entity\Image::DEFAULT_IMG_W;
        if (count($event->getImages()) > 0) {
            if ($event->getImageMain()) {
                $image = $event->getImageMain();
                if(!$image->getDeletedDate()){
                    return $image->getImageEventBox()->getWebFilePath();
                }
            } else {
                $images = $event->getImages();
                foreach($images as $image){
                    if (!$image->getDeletedDate()) {
                        return $image->getImageEventBox()->getWebFilePath();
                    }
                }
            }
        }
        return $route;
    }

    public function getEventImgDetailThumbnail(Event $event)
    {
        $route = \Res\ImageBundle\Entity\Image::DEFAULT_IMG;
        if (count($event->getImages()) > 0) {
            $image = $event->getImages()->first();
            $route = $image->getImageEventCarouselThumbnail()->getWebFilePath();
        }
        return $route;
    }

    public function getEventImgsDetail(Event $event)
    {
        $count = 0;
        $route[$count]['image'] = \Res\ImageBundle\Entity\Image::DEFAULT_IMG_D;
        $route[$count]['thumb'] = \Res\ImageBundle\Entity\Image::DEFAULT_IMG;

        if (count($event->getImages()) > 0) {
            $images = $event->getImages();
            foreach($images as $i){
                if (!$i->getDeletedDate()) {
                    $route[$count]['image'] = $i->getImageEventCarousel()->getWebFilePath();
                    $route[$count]['thumb'] = $i->getImageEventCarouselThumbnail()->getWebFilePath();
                    $count++;
                }
            }
        }

        return $route;
    }
}
