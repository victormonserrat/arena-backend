<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Factory;

use AppBundle\Entity\User;

/**
 * Class UserFactory.
 */
class UserFactory
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * ActivityFactory constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return User
     */
    public function createNew(): User
    {
        return $this->factory->createNew();
    }

    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $email
     *
     * @return User
     *
     * @internal param string $password
     */
    public function create(string $username, string $plainPassword, string $email): User
    {
        /** @var User $user */
        $user = $this->createNew();
        $user
            ->setUsername($username)
            ->setPlainPassword($plainPassword)
            ->setEmail($email)
            ->setEnabled(true);

        return $user;
    }
}
