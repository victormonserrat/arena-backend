<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security\Voter;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Registration;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class ActivityVoter.
 */
class ActivityVoter extends Voter
{
    const READ_REGISTRATIONS = 'read_registrations';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject): bool
    {
        if (!in_array($attribute, array(self::READ_REGISTRATIONS))) {
            return false;
        }

        if (!$subject instanceof Activity) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param Activity       $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::READ_REGISTRATIONS:
                return $this->isInvolved($subject, $user);
            default:
                return false;
        }
    }

    /**
     * @param Activity $activity
     * @param User     $user
     *
     * @return bool
     */
    private function isInvolved(Activity $activity, User $user): bool
    {
        if ($activity->getOwner()->getId() === $user->getId()) {
            return true;
        }

        foreach ($activity->getAcceptedRegistrations() as $registration) {
            /** @var Registration $registration */
            if ($registration->getUser()->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }
}
