<?php

namespace App\Security\Voter;

use App\Entity\Order;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['view'])
            && $subject instanceof Order;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Order $subject */
        return $subject->getUser() == $user;
    }
}
