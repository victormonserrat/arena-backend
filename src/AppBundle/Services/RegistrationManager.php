<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use AppBundle\Entity\Registration;
use AppBundle\EventDispatcher\RegistrationEventDispatcher;
use AppBundle\Factory\RegistrationFactory;
use AppBundle\Repository\RegistrationRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class RegistrationManager.
 */
class RegistrationManager
{
    /**
     * @var RegistrationFactory
     */
    private $registrationFactory;

    /**
     * @var RegistrationRepository
     */
    private $registrationRepository;

    /**
     * @var RegistrationEventDispatcher
     */
    private $registrationEventDispatcher;

    /**
     * @var ObjectManager
     */
    private $registrationObjectManager;

    /**
     * RegistrationManager constructor.
     *
     * @param RegistrationFactory         $registrationFactory
     * @param RegistrationRepository      $registrationRepository
     * @param RegistrationEventDispatcher $registrationEventDispatcher
     * @param ObjectManager               $registrationObjectManager
     */
    public function __construct(
        RegistrationFactory $registrationFactory,
        RegistrationRepository $registrationRepository,
        RegistrationEventDispatcher $registrationEventDispatcher,
        ObjectManager $registrationObjectManager
    ) {
        $this->registrationFactory = $registrationFactory;
        $this->registrationRepository = $registrationRepository;
        $this->registrationEventDispatcher = $registrationEventDispatcher;
        $this->registrationObjectManager = $registrationObjectManager;
    }

    /**
     * @param Registration $registration
     * @param bool         $flush
     *
     * @return RegistrationManager
     */
    public function saveOne(Registration $registration, bool $flush = true): RegistrationManager
    {
        $this->registrationObjectManager->persist($registration);
        if ($flush) {
            $this->registrationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $registrations
     * @param bool  $flush
     *
     * @return RegistrationManager
     */
    public function save(array $registrations, bool $flush = true): RegistrationManager
    {
        foreach ($registrations as $registration) {
            $this->saveOne($registration, false);
        }
        if ($flush) {
            $this->registrationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Registration $application
     *
     * @return RegistrationManager
     */
    public function createApplication(Registration $application): RegistrationManager
    {
        $this->saveOne($application);
        $this->registrationEventDispatcher->createdApplicationEvent($application);

        return $this;
    }

    /**
     * @param Registration $invitation
     *
     * @return RegistrationManager
     */
    public function createInvitation(Registration $invitation): RegistrationManager
    {
        $this->saveOne($invitation);
        $this->registrationEventDispatcher->createdInvitationEvent($invitation);

        return $this;
    }

    /**
     * @param Registration $registration
     *
     * @return RegistrationManager
     */
    public function accept(Registration $registration): RegistrationManager
    {
        $registration->setStatus(Registration::ACCEPTED);
        $this->saveOne($registration);

        return $this;
    }

    /**
     * @param Registration $application
     *
     * @return RegistrationManager
     */
    public function acceptApplication(Registration $application): RegistrationManager
    {
        $this->accept($application);
        $this->registrationEventDispatcher->acceptedApplicationEvent($application);

        return $this;
    }

    /**
     * @param Registration $invitation
     *
     * @return RegistrationManager
     */
    public function acceptInvitation(Registration $invitation): RegistrationManager
    {
        $this->accept($invitation);
        $this->registrationEventDispatcher->acceptedInvitationEvent($invitation);

        return $this;
    }

    /**
     * @param Registration $registration
     *
     * @return RegistrationManager
     */
    public function refuse(Registration $registration): RegistrationManager
    {
        $registration->setStatus(Registration::REFUSED);
        $this->saveOne($registration);

        return $this;
    }

    /**
     * @param Registration $application
     *
     * @return RegistrationManager
     */
    public function refuseApplication(Registration $application): RegistrationManager
    {
        $this->refuse($application);
        $this->registrationEventDispatcher->refusedApplicationEvent($application);

        return $this;
    }

    /**
     * @param Registration $invitation
     *
     * @return RegistrationManager
     */
    public function refuseInvitation(Registration $invitation): RegistrationManager
    {
        $this->refuse($invitation);
        $this->registrationEventDispatcher->refusedInvitationEvent($invitation);

        return $this;
    }

    /**
     * @param Registration $registration
     * @param bool         $flush
     *
     * @return RegistrationManager
     */
    public function removeOne(Registration $registration, bool $flush = true): RegistrationManager
    {
        $this->registrationObjectManager->remove($registration);
        if ($flush) {
            $this->registrationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $registrations
     * @param bool  $flush
     *
     * @return RegistrationManager
     */
    public function remove(array $registrations, bool $flush = true): RegistrationManager
    {
        foreach ($registrations as $registration) {
            $this->removeOne($registration, false);
        }
        if ($flush) {
            $this->registrationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Registration $registration
     *
     * @return RegistrationManager
     */
    public function delete(Registration $registration): RegistrationManager
    {
        $this->removeOne($registration);
        $this->registrationEventDispatcher->deletedRegistrationEvent($registration);

        return $this;
    }
}
