<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Hook;

use AppBundle\Behat\Composition\KernelAwareTrait;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Symfony2Extension\Context\KernelAwareContext;

/**
 * Class HookContext.
 *
 * @codeCoverageIgnore
 */
class DoctrineORMContext implements Context, KernelAwareContext
{
    use KernelAwareTrait;

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function purgeDatabase(BeforeScenarioScope $scope)
    {
        $this->getContainer()->get('knp_rad_fixtures_load.reset_schema_processor')->resetDoctrineSchema();
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $em->flush();
    }
}
