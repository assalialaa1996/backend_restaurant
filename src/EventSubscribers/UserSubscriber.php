<?php

namespace App\EventSubscribers;

use App\Entity\Account;
use ApiPlatform\Core\EventListener\EventPriorities;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubscriber implements EventSubscriberInterface {
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->passwordEncoder = $userPasswordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['hashingPlainPassword', EventPriorities::POST_VALIDATE],
        ];
    }

    public function hashingPlainPassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        if ($user instanceof Account)
        {
            if ($event->getRequest()->isMethod('POST')) {
                $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setCreatedAt(new DateTime('now'));
                $user->setUpdateAt(new DateTime('now'));
                $user->setRoles(['ROLE_USER']);
            }
            else if ($event->getRequest()->isMethod('PUT')){
                $user->setUpdateAt(new DateTime('now'));
            }
        }
    }
}
