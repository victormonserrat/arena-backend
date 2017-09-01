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
use AppBundle\Services\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class MeDeleteAction.
 */
class MeDeleteAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * MeDeleteAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param UserManager           $userManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        UserManager $userManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
    }

    /**
     * @Route(
     *     name="api_me_delete_item",
     *     path="/me",
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("DELETE")
     *
     * @return Response
     */
    public function __invoke()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $this->userManager->delete($user);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
