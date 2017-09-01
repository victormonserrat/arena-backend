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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ActivityGetAction.
 */
class ActivityGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * ActivityGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *     name="api_activities_get_item",
     *     path="/activities/{id}",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="get"}
     * )
     * @Method("GET")
     *
     * @param Activity $data
     *
     * @return Activity
     */
    public function __invoke(Activity $data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            $data->setStatusWithUser($user);
        } else {
            $data->setStatus(Activity::NOT_LOGGED);
        }

        return $data;
    }
}
