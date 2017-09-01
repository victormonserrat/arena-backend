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
use AppBundle\Factory\RegistrationFactory;
use AppBundle\Services\RegistrationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ActivityApplyAction.
 */
class ActivityApplyAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var RegistrationFactory
     */
    private $registrationFactory;

    /**
     * @var RegistrationManager
     */
    private $registrationManager;

    /**
     * ActivityApplyAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param RegistrationFactory   $registrationFactory
     * @param RegistrationManager   $registrationManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        RegistrationFactory $registrationFactory,
        RegistrationManager $registrationManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->registrationFactory = $registrationFactory;
        $this->registrationManager = $registrationManager;
    }

    /**
     * @Route(
     *     name="api_activities_apply_item",
     *     path="/activities/{id}/apply",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="apply"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("POST")
     *
     * @param Activity $data
     *
     * @return Response
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($data->getOwner()->getId() === $user->getId()) {
            throw new AccessDeniedException('User is the owner');
        }

        $registrations = $data->getRegistrations()->filter(function ($registration) use ($user) {
            /* @var Registration $registration */
            return $registration->getUser()->getId() === $user->getId()
                && (!$registration->isRefused());
        });
        if (!$registrations->isEmpty()) {
            /** @var Registration $registration */
            $registration = $registrations->first();
            if ($registration->isAccepted()) {
                throw new AccessDeniedException('User is already registered');
            } elseif ($registration->isApplication()) {
                throw new AccessDeniedException('User is already applicant');
            } else {
                throw new AccessDeniedException('User is already invited');
            }
        }

        $application = $this->registrationFactory->createApplication($user, $data);

        $this->registrationManager->createApplication($application);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
