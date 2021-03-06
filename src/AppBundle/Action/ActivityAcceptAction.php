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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ActivityAcceptAction.
 */
class ActivityAcceptAction
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
     * ActivityAcceptAction constructor.
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
     *     name="api_activities_accept_item",
     *     path="/activities/{id}/accept",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="accept"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("PATCH")
     *
     * @param Activity $data
     *
     * @return Response
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $invitations = $data->getInvitations()->filter(function ($invitation) use ($user) {
            /* @var Registration $invitation */
            return $invitation->getUser()->getId() === $user->getId();
        });
        if ($invitations->isEmpty()) {
            throw new AccessDeniedException('User is not invited');
        }

        $registrations = $data->getAcceptedRegistrationsCount();
        if ($data->getSeats() !== null && $registrations >= $data->getSeats()) {
            throw new AccessDeniedException('Activity is full');
        }

        $application = $data->getApplications()->filter(function ($application) use ($user) {
            /* @var Registration $application */
            return $application->getUser()->getId() === $user->getId();
        });
        if (!$application->isEmpty()) {
            $this->registrationManager->delete($application->first());
        }

        $this->registrationManager->acceptInvitation($invitations->first());

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
