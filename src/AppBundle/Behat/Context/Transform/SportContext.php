<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Transform;

use AppBundle\Behat\Context\DefaultContext;
use AppBundle\Entity\Sport;
use AppBundle\Factory\SportFactory;
use Behat\Gherkin\Node\TableNode;

/**
 * Class SportContext.
 */
class SportContext extends DefaultContext
{
    /**
     * @Transform table:Name,Description
     *
     * @param TableNode $table
     *
     * @return array
     */
    public function castTable(TableNode $table): array
    {
        /** @var SportFactory $sportFactory */
        $sportFactory = $this->getService('arena.factory.sport');

        $sports = array();
        foreach ($table as $row) {
            /** @var Sport $sport */
            $sport = $sportFactory->create($row['Name']);
            $sport->setDescription($row['Description']);

            $sports[] = $sport;
        }

        return $sports;
    }

    /**
     * @Transform table:Name
     *
     * @param TableNode $table
     *
     * @return array
     */
    public function castNameTable(TableNode $table): array
    {
        /** @var SportFactory $sportFactory */
        $sportFactory = $this->getService('arena.factory.sport');

        $sports = array();
        foreach ($table as $row) {
            /** @var Sport $sport */
            $sport = $sportFactory->create($row['Name']);

            $sports[] = $sport;
        }

        return $sports;
    }

    /**
     * @Transform /^this sport$/
     */
    public function castThisSport(): Sport
    {
        return $this->sharedStorage->get('sport');
    }

    /**
     * @Transform :sport
     *
     * @param $name
     *
     * @return Sport
     */
    public function castName($name): Sport
    {
        /** @var SportFactory $sportFactory */
        $sportFactory = $this->getService('arena.factory.sport');

        /** @var Sport $sport */
        $sport = $sportFactory->create($name);

        return $sport;
    }
}
