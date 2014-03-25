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
class ImageEventBox extends ImageCopy
{
    protected $maxWidth = 410;
    protected $maxHeight = 258;
    protected $sufix = "box";
    protected $crop = true;
}