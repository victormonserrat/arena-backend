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
use AppBundle\Entity\Notification;
use AppBundle\Event\CreatedNotificationEvent;

/**
 * Class NotificationEventDispatcher.
 */
class NotificationEventDispatcher extends AbstractEventDispatcher
{
    /**
     * @param Notification $notification
     *
     * @return NotificationEventDispatcher
     */
    public function createdNotificationEvent(Notification $notification): NotificationEventDispatcher
    {
        $event = new CreatedNotificationEvent($notification);

        $this->eventDispatcher->dispatch(ArenaEvents::CREATED_NOTIFICATION, $event);

        return $this;
    }
}
