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
use AppBundle\Services\ActivityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ActivityPutAction.
 */
class ActivityPutAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var ActivityManager
     */
    private $activityManager;

    /**
     * ActivityPutAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param ActivityManager       $activityManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ActivityManager $activityManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->activityManager = $activityManager;
    }

    /**
     * @Route(
     *     name="api_activities_put_item",
     *     path="/activities/{id}",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="put"}
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("PUT")
     *
     * @param Activity $data
     *
     * @return Activity
     */
    public function __invoke($data)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($data->getOwner()->getId() !== $user->getId()) {
            throw new AccessDeniedException('User is not the owner');
        }

        $this->activityManager->update($data);

        return $data;
    }
}
