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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MeGetAction.
 */
class MeGetAction
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * MeGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param SerializerInterface   $serializer
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     name="api_me_get_item",
     *     path="/me",
     * )
     * @Security("has_role('ROLE_USER')")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function __invoke()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return new Response($this->serializer->serialize($user, 'jsonld'));
    }
}
