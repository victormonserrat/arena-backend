<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context;

use AppBundle\Behat\Composition\KernelAwareTrait;
use AppBundle\Behat\Composition\SharedStorageTrait;
use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DefaultContext.
 *
 * @codeCoverageIgnore
 */
abstract class DefaultContext implements Context, KernelAwareContext
{
    use KernelAwareTrait;
    use SharedStorageTrait;

    /**
     * @var string
     */
    protected $applicationName = 'arena';

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * DefaultContext constructor.
     *
     * @param null $applicationName
     */
    public function __construct($applicationName = null)
    {
        \Locale::setDefault('es');

        $this->faker = Factory::create();

        if (null !== $applicationName) {
            $this->applicationName = $applicationName;
        }
    }

    /**
     * @param string $resourceName
     *
     * @return EntityRepository
     */
    protected function getRepository($resourceName)
    {
        return $this->getService($this->applicationName.'.repository.'.$resourceName);
    }

    /**
     * Get service by id.
     *
     * @return object The associated service
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Dispatch an event.
     *
     * @param $eventName
     * @param Event $event
     *
     * @return Event
     */
    protected function dispatch($eventName, Event $event)
    {
        return $this->getContainer()->get('event_dispatcher')->dispatch($eventName, $event);
    }
}
