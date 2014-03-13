<?php

namespace Res\FrontendBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomController extends Controller
{
    protected function setTranslatedFlashMessage($message, $class = 'info')
    {
        $translatedMessage = $this->get('translator')->trans($message);
        $this->get('session')->getFlashBag()->set($class, $translatedMessage);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function renderLoginTemplate($template)
    {
        $request = $this->getRequest();
        $sesion = $request->getSession();
        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR));

        return $this->render($template, array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error));
    }
}
