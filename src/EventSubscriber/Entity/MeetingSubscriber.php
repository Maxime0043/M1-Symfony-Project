<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Meeting;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class MeetingSubscriber implements EventSubscriberInterface
{
    public function postLoad(LifecycleEventArgs $event): void
    {
        if($event->getEntity() instanceof Meeting){
            $event->getEntity()->prevImage = $event->getEntity()->getPicture();
            // dd($event->getEntity());
        }
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postLoad,
        ];
    }
}
