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

use AppBundle\Entity\Sport;

/**
 * Class SportFactory.
 */
class SportFactory
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
     * @return Sport
     */
    public function createNew(): Sport
    {
        return $this->factory->createNew();
    }

    /**
     * @param string $name
     *
     * @return Sport
     */
    public function create(string $name): Sport
    {
        /** @var Sport $sport */
        $sport = $this->createNew();
        $sport->setName($name);

        return $sport;
    }
}
