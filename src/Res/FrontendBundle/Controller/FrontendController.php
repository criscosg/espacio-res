<?php

namespace Res\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Form\ContactType;

class FrontendController extends Controller
{
    public function indexAction()
    {
    	$form = $this->createForm(new ContactType());

        return $this->render('FrontendBundle:Commons:index.html.twig', array('form' => $form->createView()));
    }
}
