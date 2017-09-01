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

use AppBundle\Entity\Registration;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractRegistrationEvent.
 */
abstract class AbstractRegistrationEvent extends Event
{
    /**
     * @var Registration
     */
    private $registration;

    /**
     * AbstractRegistrationEvent constructor.
     *
     * @param Registration $registration
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * @return Registration
     */
    public function getRegistration(): Registration
    {
        return $this->registration;
    }
}
