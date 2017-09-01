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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ActivitiesGetAction.
 */
class ActivitiesGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * ActivitiesGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *     name="api_activities_get_collection",
     *     path="/activities",
     *     defaults={"_api_resource_class"=Activity::class, "_api_collection_operation_name"="get"}
     * )
     * @Method("GET")
     *
     * @param $data
     *
     * @return array
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            /** @var Activity $activity */
            foreach ($data as $activity) {
                $activity->setStatusWithUser($user);
            }
        } else {
            /** @var Activity $activity */
            foreach ($data as $activity) {
                $activity->setStatus(Activity::NOT_LOGGED);
            }
        }

        return $data;
    }
}
