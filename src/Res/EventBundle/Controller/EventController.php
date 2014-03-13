<?php

namespace Res\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Controller\CustomController;

class EventController extends CustomController
{
    public function listAction()
    {
        $entityManager = $this->getEntityManager();
        return $this->render('EventBundle:Default:index.html.twig');
    }
}
