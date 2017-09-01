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

use AppBundle\Entity\Communication;
use AppBundle\Entity\User;

class CommunicationFactory
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * CommunicationFactory constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Communication
     */
    public function createNew(): Communication
    {
        return $this->factory->createNew();
    }

    /**
     * @param string $subject
     * @param string $body
     * @param User   $user
     *
     * @return Communication
     */
    public function create(string $subject, string $body, User $user): Communication
    {
        $communication = $this->createNew();
        $communication
            ->setSubject($subject)
            ->setBody($body)
            ->setSentAt(new \DateTime('now'))
            ->setUser($user);

        return $communication;
    }
}
