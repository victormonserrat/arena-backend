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

use AppBundle\Entity\Activity;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractActivityEvent.
 */
abstract class AbstractActivityEvent extends Event
{
    /**
     * @var Activity
     */
    private $activity;

    /**
     * AbstractActivityEvent constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }
}
