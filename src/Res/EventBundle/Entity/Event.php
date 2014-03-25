<?php

namespace Res\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Res\ImageBundle\Entity\ImageEvent;
use Res\EventBundle\Entity\EventRepository;

/**
 * @ORM\Entity(repositoryClass="Res\EventBundle\Entity\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    protected $slug;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Res\ImageBundle\Entity\ImageEvent", mappedBy="event", cascade={"persist", "merge", "remove"})
     * @ORM\OrderBy({"main" = "DESC"})
     */
    private $images;


    public function __toString()
    {
        return $this->getTitle();
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Res\ImageBundle\Entity\ImageEvent
     */
    public function getImage()
    {
        return $this->images->first();
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function addImage(ImageEvent $image)
    {
        $this->images->add($image);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getImageMain()
    {
        foreach ($this->images as $image) {
            if ($image->getMain()) {
                return $image;
            }
        }

        return false;
    }

    public function getFormatDate()
    {
        $date = $this->getDate();

        return $date->format('Y-m-d');
    }
}
