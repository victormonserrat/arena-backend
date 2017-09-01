<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Factory;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Registration;
use AppBundle\Entity\User;

/**
 * Class RegistrationFactory.
 */
class RegistrationFactory
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * ActivityFactory constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Registration
     */
    public function createNew(): Registration
    {
        /** @var Registration $registration */
        $registration = $this->factory->createNew();
        $registration
            ->setCreatedAt(new \DateTime('now'))
            ->setStatus(Registration::WAITING);

        return $registration;
    }

    /**
     * @return Registration
     */
    public function createNewApplication(): Registration
    {
        /** @var Registration $application */
        $application = $this->createNew();
        $application->setType(Registration::APPLICATION);

        return $application;
    }

    /**
     * @return Registration
     */
    public function createNewInvitation(): Registration
    {
        /** @var Registration $application */
        $invitation = $this->createNew();
        $invitation->setType(Registration::INVITATION);

        return $invitation;
    }

    /**
     * @param User     $user
     * @param Activity $activity
     *
     * @return Registration
     */
    public function createApplication(User $user, Activity $activity): Registration
    {
        $application = $this->createNewApplication();
        $application
            ->setUser($user)
            ->setActivity($activity);

        return $application;
    }

    /**
     * @param User     $user
     * @param Activity $activity
     *
     * @return Registration
     */
    public function createInvitation(User $user, Activity $activity): Registration
    {
        $invitation = $this->createNewInvitation();
        $invitation
            ->setUser($user)
            ->setActivity($activity);

        return $invitation;
    }
}
