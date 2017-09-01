<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Action;

use AppBundle\Entity\Registration;
use AppBundle\Entity\User;
use AppBundle\Services\RegistrationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RegistrationPostAction.
 */
class RegistrationPostAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var RegistrationManager
     */
    private $registrationManager;

    /**
     * ActivityPostAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param RegistrationManager   $registrationManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        RegistrationManager $registrationManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->registrationManager = $registrationManager;
    }

    /**
     * @Route(
     *     name="api_registrations_post_collection",
     *     path="/registrations",
     *     defaults={"_api_resource_class"=Registration::class, "_api_collection_operation_name"="post"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("POST")
     *
     * @param Registration $data
     *
     * @return Registration
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($data->getActivity()->getOwner()->getId() !== $user->getId()) {
            throw new AccessDeniedException('User is not the owner');
        }

        if ($data->getUser()->getId() === $user->getId()) {
            throw new AccessDeniedException('User is the owner');
        }

        $registration = $data->getActivity()->getAcceptedRegistrations()->filter(function ($registration) use ($data) {
            /* @var Registration $registration */
            return $registration->getUser()->getId() === $data->getUser()->getId();
        });
        if (!$registration->isEmpty()) {
            throw new AccessDeniedException('User is already registered');
        }

        $invitation = $data->getActivity()->getInvitations()->filter(function ($invitation) use ($data) {
            /* @var Registration $invitation */
            return $invitation->getUser()->getId() === $data->getUser()->getId();
        });
        if (!$invitation->isEmpty()) {
            throw new AccessDeniedException('User is already invited');
        }

        $data
        ->setType(Registration::INVITATION)
        ->setStatus(Registration::WAITING);

        $this->registrationManager->createInvitation($data);

        return $data;
    }
}
