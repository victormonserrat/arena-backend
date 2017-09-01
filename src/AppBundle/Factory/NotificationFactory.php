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

use AppBundle\Entity\Activity;
use AppBundle\Entity\Notification;
use AppBundle\Entity\User;

class NotificationFactory
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * NotificationFactory constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Notification
     */
    public function createNew(): Notification
    {
        return $this->factory->createNew();
    }

    /**
     * @param string   $type
     * @param User     $user
     * @param Activity $activity
     *
     * @return Notification
     */
    public function create(string $type, User $user, Activity $activity): Notification
    {
        $notification = $this->createNew();
        $notification
            ->setType($type)
            ->setSentAt(new \DateTime('now'))
            ->setUser($user)
            ->setActivity($activity);

        return $notification;
    }
}
