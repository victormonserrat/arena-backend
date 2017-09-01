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

use AppBundle\Entity\Activity;
use AppBundle\EventDispatcher\ActivityEventDispatcher;
use AppBundle\Factory\ActivityFactory;
use AppBundle\Repository\ActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ActivityManager.
 */
class ActivityManager
{
    /**
     * @var ActivityFactory
     */
    private $activityFactory;

    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    /**
     * @var ActivityEventDispatcher
     */
    private $activityEventDispatcher;

    /**
     * @var ObjectManager
     */
    private $activityObjectManager;

    /**
     * ActivityManager constructor.
     *
     * @param ActivityFactory         $activityFactory
     * @param ActivityRepository      $activityRepository
     * @param ActivityEventDispatcher $activityEventDispatcher
     * @param ObjectManager           $activityObjectManager
     */
    public function __construct(
        ActivityFactory $activityFactory,
        ActivityRepository $activityRepository,
        ActivityEventDispatcher $activityEventDispatcher,
        ObjectManager $activityObjectManager
    ) {
        $this->activityFactory = $activityFactory;
        $this->activityRepository = $activityRepository;
        $this->activityEventDispatcher = $activityEventDispatcher;
        $this->activityObjectManager = $activityObjectManager;
    }

    /**
     * @param Activity $activity
     * @param bool     $flush
     *
     * @return ActivityManager
     */
    public function saveOne(Activity $activity, bool $flush = true): ActivityManager
    {
        $this->activityObjectManager->persist($activity);
        if ($flush) {
            $this->activityObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $activities
     * @param bool  $flush
     *
     * @return ActivityManager
     */
    public function save(array $activities, bool $flush = true): ActivityManager
    {
        foreach ($activities as $activity) {
            $this->saveOne($activity, false);
        }
        if ($flush) {
            $this->activityObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Activity $activity
     *
     * @return ActivityManager
     */
    public function create(Activity $activity): ActivityManager
    {
        $this->saveOne($activity);
        $this->activityEventDispatcher->createdActivityEvent($activity);

        return $this;
    }

    /**
     * @param Activity $activity
     *
     * @return ActivityManager
     */
    public function update(Activity $activity): ActivityManager
    {
        $this->saveOne($activity);
        $this->activityEventDispatcher->updatedActivityEvent($activity);

        return $this;
    }

    /**
     * @param Activity $activity
     * @param bool     $flush
     *
     * @return ActivityManager
     */
    public function removeOne(Activity $activity, bool $flush = true): ActivityManager
    {
        $this->activityObjectManager->remove($activity);
        if ($flush) {
            $this->activityObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $activities
     * @param bool  $flush
     *
     * @return ActivityManager
     */
    public function remove(array $activities, bool $flush = true): ActivityManager
    {
        foreach ($activities as $activity) {
            $this->removeOne($activity, false);
        }
        if ($flush) {
            $this->activityObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Activity $activity
     *
     * @return ActivityManager
     */
    public function delete(Activity $activity): ActivityManager
    {
        $this->removeOne($activity);
        $this->activityEventDispatcher->deletedActivityEvent($activity);

        return $this;
    }
}
