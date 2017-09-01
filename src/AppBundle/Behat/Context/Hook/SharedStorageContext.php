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

use Behat\Behat\Context\Context;

/**
 * Class SharedStorageContext.
 */
class SharedStorageContext implements Context
{
    /**
     * @var array
     */
    private $clipboard = [];

    /**
     * @var string|null
     */
    private $latestKey;

    /**
     * @BeforeScenario
     */
    public function cleanClipboard()
    {
        $this->clipboard = [];
        $this->latestKey = null;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        if (!isset($this->clipboard[$key])) {
            throw new \InvalidArgumentException(sprintf('There is no current resource for "%s"!', $key));
        }

        return $this->clipboard[$key];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->clipboard[$key]);
    }

    /**
     * @param $key
     * @param $resource
     */
    public function set($key, $resource)
    {
        $this->clipboard[$key] = $resource;
        $this->latestKey = $key;
    }

    /**
     * @return mixed
     */
    public function getLatestResource()
    {
        if (!isset($this->clipboard[$this->latestKey])) {
            throw new \InvalidArgumentException(sprintf('There is no latest resource!', $this->latestKey));
        }

        return $this->clipboard[$this->latestKey];
    }

    /**
     * @param array $clipboard
     */
    public function setClipboard(array $clipboard)
    {
        $this->clipboard = $clipboard;
    }
}
