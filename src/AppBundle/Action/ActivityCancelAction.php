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
 * Class ActivityCancelAction.
 */
class ActivityCancelAction
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
     * ActivityCancelAction constructor.
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
     *     name="api_activities_cancel_item",
     *     path="/activities/{id}/cancel",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="cancel"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("DELETE")
     *
     * @param Activity $data
     *
     * @return Response
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $registrations = $data->getRegistrations()->filter(function ($registration) use ($user) {
            /* @var Registration $registration */
            return $registration->getUser()->getId() === $user->getId()
                && ($registration->isAccepted() || $registration->isApplication());
        });
        if ($registrations->isEmpty()) {
            throw new AccessDeniedException('User is not registered or applicant');
        }

        $this->registrationManager->delete($registrations->first());

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
