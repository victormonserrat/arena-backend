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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MePutAction.
 */
class MePutAction
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
     * @var Serializer
     */
    private $serializer;

    /**
     * MePutAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param SerializerInterface   $serializer
     * @param UserManager           $userManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer,
        UserManager $userManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
        $this->userManager = $userManager;
    }

    /**
     * @Route(
     *     name="api_me_put_item",
     *     path="/me",
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("PUT")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $body = $request->getContent();
        if (!empty($body)) {
            $params = \json_decode($body, true);
        } else {
            throw new \InvalidArgumentException();
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $user->setFullName($params['fullName']);
        $this->userManager->update($user);

        return new Response($this->serializer->serialize($user, 'jsonld'));
    }
}
