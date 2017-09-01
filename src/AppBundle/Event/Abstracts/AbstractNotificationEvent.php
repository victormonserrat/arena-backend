<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Event\Abstracts;

use AppBundle\Entity\Notification;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractNotificationEvent.
 */
abstract class AbstractNotificationEvent extends Event
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * AbstractNotificationEvent constructor.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }
}
