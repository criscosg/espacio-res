<?php

namespace Res\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Form\ContactType;
use Res\FrontendBundle\Controller\CustomController;
use Res\EventBundle\Entity\Event;

class FrontendController extends CustomController
{
    public function indexAction()
    {
        $form = $this->createForm(new ContactType());

        return $this->render('FrontendBundle:Commons:index.html.twig', array('form' => $form->createView()));
    }

    public function indexNewAction()
    {
        //$form = $this->createForm(new ContactType());

        //return $this->render('FrontendBundle:Commons:index.html.twig', array('form' => $form->createView()));
        return $this->render('FrontendBundle:New:Pages/index.html.twig');
    }

}
