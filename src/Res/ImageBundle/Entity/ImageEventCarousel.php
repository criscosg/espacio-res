<?php
namespace Res\ImageBundle\Entity;
use Doctrine\Tests\DBAL\Types\IntegerTest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ImageEventCarousel extends ImageCopy
{
    protected $maxWidth = 835;
    protected $maxHeight = 492;
    protected $sufix = "carousel";
    protected $crop = true;
}