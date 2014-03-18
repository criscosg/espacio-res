<?php

namespace Res\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Controller\CustomController;
use Res\BackendBundle\Util\FunctionsHelper;
use Res\EventBundle\Entity\Event;
use Res\ImageBundle\Entity\Image;

class ImageController extends CustomController
{
    public function deleteImageAction($id)
    {
        $jsonResponse = json_encode(array('ok' => false));
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $em = $this->get('doctrine')->getManager();
            $image = $em->getRepository('ImageBundle:Image')->findOneBy(array('id' => $id));
            if (!$image) {
                return $this->noPermission();
            }
            foreach ($image->getImageCopies() as $copy)
            {
                $copy->setDateRemove(new \DateTime('now'));
                $em->flush();
            }
            $image->setDeletedDate(new \DateTime('now'));
            if (FunctionsHelper::isClass($image, "imageEvent") && $image->getMain()) {
                $image->setMain(false);
            }
            $em->flush();
            $jsonResponse = json_encode(array('ok' => true));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }

    public function changeImageMainAction($slugEvent, $idImage)
    {
        $jsonResponse = json_encode(array('ok' => false));
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $em = $this->getEntityManager();
            $event = $em->getRepository('EventBundle:Event')->findOneBy(array('slug' => $slugEvent));
            $newMain = $em->getRepository('ImageBundle:ImageEvent')->findOneBy(array('id' => $idImage));
            if (!$newMain) {
                return $this->getHttpJsonResponse($jsonResponse);
            }
            $oldMain = $event->getImageMain();
            if ($oldMain && $oldMain->getId() != $newMain->getId()) {
                $newMain->setMain(true);
                $oldMain->setMain(false);
                $em->persist($newMain);
                $em->persist($oldMain);
                $em->flush();
                $jsonResponse = json_encode(array('ok' => true));
            }
            if (!$oldMain) {
                $newMain->setMain(true);
                $em->persist($newMain);
                $em->flush();
                $jsonResponse = json_encode(array('ok' => true));
            }
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }
}
