<?php

namespace Res\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Res\FrontendBundle\Controller\CustomController;
use Res\EventBundle\Entity\Event;

class EventController extends CustomController
{

    public function getEventsAction()
    {
        $jsonResponse = json_encode(array('ok' => false));
        $request = $this->getRequest();
        $month = $request->request->get('month');
        $year = $request->request->get('year');

        if ($request->isXmlHttpRequest()) {
            $em = $this->get('doctrine')->getManager();
            $events = $em->getRepository('EventBundle:Event')->findEventsFromDate($month, $year);
            if (!$events) {
                return $this->noPermission();
            }

            $eventJSON = array();

            foreach ($events as $event)
            {
                $path = $event->getImageMain()->getImageEventCarouselThumbnail()->getWebFilePath();
                $path = $this->container->get('templating.helper.assets')->getUrl($path);

                $eventItem = array('id' => $event->getId(), 'title' => $event->getTitle(),
                    'img' => $path, 'date' => $event->getFormatDate());
                $eventJSON[] = $eventItem;
            }
            $jsonResponse = json_encode(array('ok' => true, 'events' => $eventJSON));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }

    public function getEventDetailAction()
    {
        $jsonResponse = json_encode(array('ok' => false));
        $request = $this->getRequest();
        $id = $request->request->get('id');

        if ($request->isXmlHttpRequest()) {
            $em = $this->get('doctrine')->getManager();
            $event = $em->getRepository('EventBundle:Event')->findOneById($id);

            if (!$event) {
                return $this->noPermission();
            }

            $path = $event->getImageMain()->getImageEventCarousel()->getWebFilePath();
            $path = $this->container->get('templating.helper.assets')->getUrl($path);

            $eventJSON = array('id' => $event->getId(), 'title' => $event->getTitle(),
                    'img' => $path, 'date' => $event->getFormatDate(), 'description' => $event->getDescription());

            $jsonResponse = json_encode(array('ok' => true, 'event' => $eventJSON));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }
}
