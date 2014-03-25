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
    protected $maxWidth = 910;
    protected $maxHeight = 536;
    protected $sufix = "carousel";
    protected $crop = true;
}