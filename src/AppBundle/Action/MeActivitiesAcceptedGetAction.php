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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class MeActivitiesAcceptedGetAction.
 */
class MeActivitiesAcceptedGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * MeActivitiesAcceptedGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *     name="api_me_activities_accepted_get_collection",
     *     path="/me/activities/accepted",
     *     defaults={"_api_resource_class"=Activity::class, "_api_collection_operation_name"="get"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("GET")
     *
     * @return array
     */
    public function __invoke()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $activities = [];
        /** @var Registration $registration */
        foreach ($user->getAcceptedRegistrations() as $registration) {
            $activity = $registration->getActivity();
            $activity->setStatus(Activity::REGISTERED);
            $activities[] = $activity;
        }

        return $activities;
    }
}
