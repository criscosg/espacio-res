<?php

namespace Res\ImageBundle\Entity;

use Res\ImageBundle\Entity\Image;
use Res\ImageBundle\Util\FileHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ImageEvent extends Image
{
    CONST MAX_WIDTH = 1024;
    CONST MAX_HEIGHT = 768;
    protected $subdirectory = "images/event";
    protected $maxWidth = self::MAX_WIDTH;
    protected $maxHeight = self::MAX_HEIGHT;

    /**
     * @var Res\EventBundle\Entity\Event
     *
     * @ORM\ManyToOne(targetEntity="Res\EventBundle\Entity\Event", inversedBy="images")
     */
    protected $event;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" = 0})
     */
    protected $main = false;

    public function setEvent(\Res\EventBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function createImageEventCarouselThumbnail()
    {
        $thumb = $this->getImageEventCarouselThumbnail();
        if (!$thumb) {
            $thumb = new ImageEventCarouselThumbnail();
        }

        return $thumb;
    }

    public function createImageEventCarousel()
    {
        $thumb = $this->getImageEventCarousel();
        if (!$thumb) {
            $thumb = new ImageEventCarousel();
        }

        return $thumb;
    }

    public function createImageEventBox()
    {
        $thumb = $this->getImageEventBox();
        if (!$thumb) {
            $thumb = new ImageEventBox();
        }

        return $thumb;
    }

    public function createCopies()
    {
        list($oldRoute, $copies) = parent::createCopies();
        if ($thumb = $this->createImageEventCarouselThumbnail()) {
            $copies[] = $thumb;
        }

        if ($eventcarousel = $this->createImageEventCarousel()) {
            $copies[] = $eventcarousel;
        }

        if ($box = $this->createImageEventBox()) {
            $copies[] = $box;
        }

        return array($oldRoute, $copies);
    }

    public function getMain()
    {
        return $this->main;
    }

    public function setMain($main)
    {
        $this->main = $main;
    }

}