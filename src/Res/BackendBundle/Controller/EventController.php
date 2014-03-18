<?php

namespace Res\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Controller\CustomController;
use Res\EventBundle\Entity\Event;
use Res\EventBundle\Form\Type\EventType;
use Res\EventBundle\Form\Handler\CreateEventFormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Res\ImageBundle\Form\Type\MultipleUploadFilesType;

class EventController extends CustomController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $events = $em->getRepository('EventBundle:Event')->findAll();
        return $this->render('BackendBundle:Event:index.html.twig', array('events' => $events));
    }

    public function createAction()
    {
        $em = $this->getEntityManager();
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);
        $formImage = $this->createForm(new MultipleUploadFilesType());
        $request = $this->getRequest();
        $formHandler = $this->get('event.create_event_form_handler');

        if ($formHandler->handle($form, $request)) {
            $this->setTranslatedFlashMessage("Evento creado");
            $formImgHandler = $this->get('image.create_image_form_handler');
            if($formImgHandler->handleMultiple($formImage, $request, $event))
                return $this->redirect($this->generateUrl('admin_events_index'));
        }

        return $this->render('BackendBundle:Event:create.html.twig', array('form' => $form->createView(), 'formImage' => $formImage->createView()));
    }

    /*
    * @ParamConverter('$event', class='EventBundle:Event')
    */
    public function editAction(Event $event)
    {
        $form = $this->createForm(new EventType(), $event);
        $request = $this->getRequest();
        $formImage = $this->createForm(new MultipleUploadFilesType());
        $formHandler = $this->get('event.create_event_form_handler');

        if ($formHandler->handle($form, $request)) {
            $this->setTranslatedFlashMessage("Evento Modificado");
            $formImgHandler = $this->get('image.create_image_form_handler');
            $formImgHandler->handleMultiple($formImage, $request, $event);

            return $this->redirect($this->generateUrl('admin_events_index'));
        }

        return $this->render('BackendBundle:Event:create.html.twig', array('form' => $form->createView(),
            'edition' => true, 'event' => $event, 'formImage' => $formImage->createView()));
    }

    /*
    * @ParamConverter('$event', class='EventBundle:Event')
    */
    public function deleteAction(Event $event)
    {
        $em = $this->getEntityManager();
        $em->remove($event);
        $em->flush();

        $this->setTranslatedFlashMessage("Se ha eliminado el evento");

        return $this->redirect($this->generateUrl('admin_events_index'));
    }
}
