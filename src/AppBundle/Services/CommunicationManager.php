<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use AppBundle\Entity\Communication;
use AppBundle\EventDispatcher\CommunicationEventDispatcher;
use AppBundle\Factory\CommunicationFactory;
use AppBundle\Repository\CommunicationRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CommunicationManager.
 */
class CommunicationManager
{
    /**
     * @var CommunicationFactory
     */
    private $communicationFactory;

    /**
     * @var CommunicationRepository
     */
    private $communicationRepository;

    /**
     * @var CommunicationEventDispatcher
     */
    private $communicationEventDispatcher;

    /**
     * @var ObjectManager
     */
    private $communicationObjectManager;

    /**
     * SportManager constructor.
     *
     * @param CommunicationFactory         $communicationFactory
     * @param CommunicationRepository      $communicationRepository
     * @param CommunicationEventDispatcher $communicationEventDispatcher
     * @param ObjectManager                $communicationObjectManager
     */
    public function __construct(
        CommunicationFactory $communicationFactory,
        CommunicationRepository $communicationRepository,
        CommunicationEventDispatcher $communicationEventDispatcher,
        ObjectManager $communicationObjectManager
    ) {
        $this->communicationFactory = $communicationFactory;
        $this->communicationRepository = $communicationRepository;
        $this->communicationEventDispatcher = $communicationEventDispatcher;
        $this->communicationObjectManager = $communicationObjectManager;
    }

    /**
     * @param Communication $communication
     * @param bool          $flush
     *
     * @return CommunicationManager
     */
    public function saveOne(Communication $communication, bool $flush = true): CommunicationManager
    {
        $this->communicationObjectManager->persist($communication);
        if ($flush) {
            $this->communicationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $communications
     * @param bool  $flush
     *
     * @return CommunicationManager
     */
    public function save(array $communications, bool $flush = true): CommunicationManager
    {
        foreach ($communications as $communication) {
            $this->saveOne($communication, false);
        }
        if ($flush) {
            $this->communicationObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param Communication $communication
     *
     * @return CommunicationManager
     */
    public function create(Communication $communication): CommunicationManager
    {
        $this->saveOne($communication);
        $this->communicationEventDispatcher->createdCommunicationEvent($communication);

        return $this;
    }
}
