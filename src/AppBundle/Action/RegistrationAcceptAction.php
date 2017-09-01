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

use AppBundle\Entity\Activity;
use AppBundle\Entity\Registration;
use AppBundle\Entity\User;
use AppBundle\Services\RegistrationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RegistrationAcceptAction.
 */
class RegistrationAcceptAction
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
     * RegistrationAcceptAction constructor.
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
     *     name="api_registrations_accept_item",
     *     path="/registrations/{id}/accept",
     *     defaults={"_api_resource_class"=Registration::class, "_api_item_operation_name"="accept"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("PATCH")
     *
     * @param Registration $data
     *
     * @return Response
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Activity $activity */
        $activity = $data->getActivity();
        if ($activity->getOwner()->getId() !== $user->getId()) {
            throw new AccessDeniedException('User is not the owner');
        }

        if (!$data->isApplication()) {
            throw new AccessDeniedException('Registration is not an application');
        }

        $registrations = $activity->getAcceptedRegistrationsCount();
        if ($activity->getSeats() !== null && $registrations >= $activity->getSeats()) {
            throw new AccessDeniedException('Activity is full');
        }

        $invitation = $activity->getInvitations()->filter(function ($invitation) use ($data) {
            /* @var Registration $invitation */
            return $invitation->getUser()->getId() === $data->getUser()->getId();
        });
        if (!$invitation->isEmpty()) {
            $this->registrationManager->delete($invitation->first());
        }

        $this->registrationManager->acceptApplication($data);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
