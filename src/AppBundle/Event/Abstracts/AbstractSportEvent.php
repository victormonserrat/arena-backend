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

use AppBundle\Entity\Sport;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractSportEvent.
 */
abstract class AbstractSportEvent extends Event
{
    /**
     * @var Sport
     */
    private $sport;

    /**
     * AbstractSportEvent constructor.
     *
     * @param Sport $sport
     */
    public function __construct(Sport $sport)
    {
        $this->sport = $sport;
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->sport;
    }
}
