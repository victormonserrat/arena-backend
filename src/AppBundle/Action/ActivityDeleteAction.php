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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ActivityDeleteAction.
 */
class ActivityDeleteAction
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
     * ActivitiesPostAction constructor.
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
     *     name="api_activities_delete_item",
     *     path="/activities/{id}",
     *     defaults={"_api_resource_class"=Activity::class, "_api_item_operation_name"="delete"}
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

        if ($data->getOwner()->getId() !== $user->getId()) {
            throw new AccessDeniedException('User is not the owner');
        }

        $this->activityManager->delete($data);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
