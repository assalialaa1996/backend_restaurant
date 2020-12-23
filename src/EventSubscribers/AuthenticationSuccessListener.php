<?php

namespace App\EventSubscribers;
use App\Entity\Account;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @param AuthenticationSuccessEvent $event
 */
class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof Account) {
            return;
        }

        $data['data'] = array(
            'id' => $user->getId(),
            'email'=>$user->getEmail(),
            'roles' => $user->getRoles(),
        );
        $event->setData($data);
    }
}
