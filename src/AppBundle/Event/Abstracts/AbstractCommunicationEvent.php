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

use AppBundle\Entity\Communication;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractCommunicationEvent.
 */
abstract class AbstractCommunicationEvent extends Event
{
    /**
     * @var Communication
     */
    private $communication;

    /**
     * AbstractCommunicationEvent constructor.
     *
     * @param Communication $communication
     */
    public function __construct(Communication $communication)
    {
        $this->communication = $communication;
    }

    /**
     * @return Communication
     */
    public function getCommunication(): Communication
    {
        return $this->communication;
    }
}
