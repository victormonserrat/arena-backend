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
use AppBundle\Entity\Sport;
use AppBundle\Entity\User;

/**
 * Class ActivityFactory.
 */
class ActivityFactory
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
     * @return Activity
     */
    public function createNew(): Activity
    {
        return $this->factory->createNew();
    }

    /**
     * @param string    $title
     * @param \DateTime $startsAt
     * @param int       $duration
     * @param Sport     $sport
     * @param User      $owner
     *
     * @return Activity
     */
    public function create(string $title, \DateTime $startsAt, int $duration, Sport $sport, User $owner): Activity
    {
        $activity = $this->createNew();
        $activity
            ->setTitle($title)
            ->setStartsAt($startsAt)
            ->setDuration($duration)
            ->setSport($sport)
            ->setOwner($owner);

        return $activity;
    }
}
