<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Domain;

use AppBundle\Behat\Context\DefaultContext;
use AppBundle\Entity\Sport;
use AppBundle\Services\SportManager;
use Behat\Gherkin\Node\PyStringNode;

/**
 * Class SportContext.
 */
class SportContext extends DefaultContext
{
    /**
     * @Given /^the sports?:$/
     *
     * @param array $sports
     */
    public function givenTheSports(array $sports)
    {
        /** @var SportManager $sportManager */
        $sportManager = $this->getService('arena.manager.sport');

        $sportManager->save($sports);
    }

    /**
     * @Given the sport :sport
     *
     * @param Sport $sport
     */
    public function givenTheSport(Sport $sport)
    {
        /** @var SportManager $sportManager */
        $sportManager = $this->getService('arena.manager.sport');

        $sportManager->saveOne($sport);

        $this->sharedStorage->set('sport', $sport);
    }

    /**
     * @Given the sport :sport with description:
     *
     * @param Sport        $sport
     * @param PyStringNode $description
     */
    public function givenTheSportWithDescription(Sport $sport, PyStringNode $description)
    {
        $sport->setDescription($description);

        /** @var SportManager $sportManager */
        $sportManager = $this->getService('arena.manager.sport');

        $sportManager->saveOne($sport);

        $this->sharedStorage->set('sport', $sport);
    }
}
