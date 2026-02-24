<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ProductVoter extends Voter
{
    public const CREATE = 'PRODUCT_CREATE';
    public const VIEW = 'PRODUCT_VIEW';
    public const EDIT = 'PRODUCT_EDIT';
    public const DELETE = 'PRODUCT_DELETE';


    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CREATE, self::VIEW, self::EDIT, self::DELETE])
            && ($subject instanceof Product || $subject === null);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
//        if (!$user instanceof UserInterface) {
//            return false;
//        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::VIEW => true,
            self::CREATE, self::EDIT, self::DELETE => $user instanceof UserInterface && in_array('ROLE_ADMIN', $user->getRoles()),
            default => false
                // logic to determine if the user can VIEW
                // return true or false
        };
    }
}
