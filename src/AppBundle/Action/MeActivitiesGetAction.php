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
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class MeActivitiesGetAction.
 */
class MeActivitiesGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * MeActivitiesGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *     name="api_me_activities_get_collection",
     *     path="/me/activities",
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

        $activities = $user->getActivities();
        /** @var Activity $activity */
        foreach ($activities as $activity) {
            $activity->setStatus(Activity::OWNER);
        }

        return $activities->toArray();
    }
}
