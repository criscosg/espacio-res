<?php

namespace Res\BackendBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Res\BackendBundle\Entity\AdminUser;

class CreateAdminUserListener implements EventSubscriber
{
    private $encoderFactory;

    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function getSubscribedEvents()
    {
        return array('prePersist');
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if($entity instanceof AdminUser) {
            $this->createSalt($entity);
        }
    }

    private function createSalt(AdminUser $user)
    {
        if (!$user->getSalt()) {
            $user->setSalt(md5(time() . AdminUser::AUTH_SALT));
            $encoder = $this->encoderFactory->getEncoder($user);
            $passwordEncoded = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($passwordEncoded);
        }
    }

}
