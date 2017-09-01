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
use AppBundle\Entity\Activity;
use AppBundle\Event\CreatedActivityEvent;
use AppBundle\Event\DeletedActivityEvent;
use AppBundle\Event\UpdatedActivityEvent;

/**
 * Class ActivityEventDispatcher.
 */
class ActivityEventDispatcher extends AbstractEventDispatcher
{
    /**
     * @param Activity $activity
     *
     * @return ActivityEventDispatcher
     */
    public function createdActivityEvent(Activity $activity): ActivityEventDispatcher
    {
        $event = new CreatedActivityEvent($activity);

        $this->eventDispatcher->dispatch(ArenaEvents::CREATED_ACTIVITY, $event);

        return $this;
    }

    /**
     * @param Activity $activity
     *
     * @return ActivityEventDispatcher
     */
    public function updatedActivityEvent(Activity $activity): ActivityEventDispatcher
    {
        $event = new UpdatedActivityEvent($activity);

        $this->eventDispatcher->dispatch(ArenaEvents::UPDATED_ACTIVITY, $event);

        return $this;
    }

    /**
     * @param Activity $activity
     *
     * @return ActivityEventDispatcher
     */
    public function deletedActivityEvent(Activity $activity): ActivityEventDispatcher
    {
        $event = new DeletedActivityEvent($activity);

        $this->eventDispatcher->dispatch(ArenaEvents::DELETED_ACTIVITY, $event);

        return $this;
    }
}
