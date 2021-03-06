<?php

namespace Res\ImageBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Res\ImageBundle\Entity\Image;
use Res\ImageBundle\Util\FileHelper;

class ImageManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createImage(Image $image)
    {
        list($oldRoute, $copies) = $image->createCopies();
        $image->uploadImage();
        $this->saveImage($image);
        $image->uploadNewCopies($copies);
        foreach ($copies as $copy) {
            $this->saveImage($copy);
        }
    }

    public function removeImage($image)
    {
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    public function saveImage($image)
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }
}
