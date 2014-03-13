<?php

namespace Res\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\BackendBundle\Entity\AdminUser;
use Res\BackendBundle\Form\Type\AdminUserType;
use Res\FrontendBundle\Controller\CustomController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;

class BackendController extends CustomController
{
    public function loginAction()
    {
        return $this->renderLoginTemplate('BackendBundle:Backend:login.html.twig');
    }

    public function registerAction()
    {
        $user = new AdminUser();
        $registerForm = $this->createForm(new AdminUserType(), $user);
        $formHandler = $this->get('admin_user.create_form_handler');

        if ($formHandler->handle($registerForm, $this->getRequest())) {
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'admin_user', $user->getRoles());

            $this->container->get('security.context')->setToken($token);
            $this->container->get('session')->set("_security_private", serialize($token));

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('BackendBundle:Backend:register.html.twig', array('form' => $registerForm->createView()));
    }
}
