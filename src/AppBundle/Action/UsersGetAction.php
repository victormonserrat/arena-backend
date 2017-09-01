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

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UsersGetAction.
 */
class UsersGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * UsersGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        TokenStorageInterface $tokenStorage
    ) {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *     name="api_users_get_collection",
     *     path="/users",
     *     defaults={"_api_resource_class"=User::class, "_api_collection_operation_name"="get"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("GET")
     *
     * @param $data
     *
     * @return array
     */
    public function __invoke($data)
    {
        /** @var User $myuser */
        $myuser = $this->tokenStorage->getToken()->getUser();

        $users = [];
        /** @var User $user */
        foreach ($data as $user) {
            if (!$user->isAdmin() && $user->getId() !== $myuser->getId()) {
                $users[] = $user;
            }
        }

        return $users;
    }
}
