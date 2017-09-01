<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventDispatcher;

use AppBundle\ArenaEvents;
use AppBundle\Entity\User;
use AppBundle\Event\CreatedUserEvent;
use AppBundle\Event\DeletedUserEvent;
use AppBundle\Event\UpdatedUserEvent;

/**
 * Class UserEventDispatcher.
 */
class UserEventDispatcher extends AbstractEventDispatcher
{
    /**
     * @param User $user
     *
     * @return UserEventDispatcher
     */
    public function createdUserEvent(User $user): UserEventDispatcher
    {
        $event = new CreatedUserEvent($user);

        $this->eventDispatcher->dispatch(ArenaEvents::CREATED_USER, $event);

        return $this;
    }

    /**
     * @param User $user
     *
     * @return UserEventDispatcher
     */
    public function updatedUserEvent(User $user): UserEventDispatcher
    {
        $event = new UpdatedUserEvent($user);

        $this->eventDispatcher->dispatch(ArenaEvents::UPDATED_USER, $event);

        return $this;
    }

    /**
     * @param User $user
     *
     * @return UserEventDispatcher
     */
    public function deletedUserEvent(User $user): UserEventDispatcher
    {
        $event = new DeletedUserEvent($user);

        $this->eventDispatcher->dispatch(ArenaEvents::DELETED_USER, $event);

        return $this;
    }
}
