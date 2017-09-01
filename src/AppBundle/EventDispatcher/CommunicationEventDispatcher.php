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
use AppBundle\Entity\Communication;
use AppBundle\Event\CreatedCommunicationEvent;

/**
 * Class CommunicationEventDispatcher.
 */
class CommunicationEventDispatcher extends AbstractEventDispatcher
{
    /**
     * @param Communication $communication
     *
     * @return CommunicationEventDispatcher
     */
    public function createdCommunicationEvent(Communication $communication): CommunicationEventDispatcher
    {
        $event = new CreatedCommunicationEvent($communication);

        $this->eventDispatcher->dispatch(ArenaEvents::CREATED_COMMUNICATION, $event);

        return $this;
    }
}
