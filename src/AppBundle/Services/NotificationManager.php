<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use AppBundle\Entity\Notification;
use AppBundle\EventDispatcher\NotificationEventDispatcher;
use AppBundle\Factory\NotificationFactory;
use AppBundle\Repository\NotificationRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class NotificationManager.
 */
class NotificationManager
{
    /**
     * @var NotificationFactory
     */
    private $notificationFactory;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * @var NotificationEventDispatcher
     */
    private $notificationEventDispatcher;

    /**
     * @var ObjectManager
     */
    private $notificationObjectManager;

    /**
     * SportManager constructor.
     *
     * @param NotificationFactory         $notificationFactory
     * @param NotificationRepository      $notificationRepository
     * @param NotificationEventDispatcher $notificationEventDispatcher
     * @param ObjectManager               $notificationObjectManager
     */
    public function __construct(
        NotificationFactory $notificationFactory,
        NotificationRepository $notificationRepository,
        NotificationEventDispatcher $notificationEventDispatcher,
        ObjectManager $notificationObjectManager
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationRepository = $notificationRepository;
        $this->notificationEventDispatcher = $notificationEventDispatcher;
        $this->notificationObjectManager = $notificationObjectManager;
    }

    /**
     * @param Notification $notification
     * @param bool         $flush
     *
     * @return NotificationManager
     */
    public function saveOne(Notification $notification, bool $flush = true): NotificationManager
    {
        $this->notificationObjectManager->persist($notification);
        if ($flush) {
            $this->notificationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $notifications
     * @param bool  $flush
     *
     * @return NotificationManager
     */
    public function save(array $notifications, bool $flush = true): NotificationManager
    {
        foreach ($notifications as $notification) {
            $this->saveOne($notification, false);
        }
        if ($flush) {
            $this->notificationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Notification $notification
     *
     * @return NotificationManager
     */
    public function create(Notification $notification): NotificationManager
    {
        $this->saveOne($notification);
        $this->notificationEventDispatcher->createdNotificationEvent($notification);

        return $this;
    }
}
