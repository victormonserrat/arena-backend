<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Composition;

use AppBundle\Behat\Context\Hook\SharedStorageContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Trait SharedStorageTrait.
 */
trait SharedStorageTrait
{
    /**
     * @var SharedStorageContext
     */
    protected $sharedStorage;

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function gatherSharedContext(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->sharedStorage = $environment->getContext(SharedStorageContext::class);
    }
}
