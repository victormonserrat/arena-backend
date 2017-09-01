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

use AppBundle\Entity\User;
use AppBundle\EventDispatcher\UserEventDispatcher;
use AppBundle\Factory\UserFactory;
use AppBundle\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserManager.
 */
class UserManager
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserEventDispatcher
     */
    private $userEventDispatcher;

    /**
     * @var UserManager
     */
    private $userObjectManager;

    /**
     * UserManager constructor.
     *
     * @param UserFactory         $userFactory
     * @param UserRepository      $userRepository
     * @param UserEventDispatcher $userEventDispatcher
     * @param ObjectManager       $userObjectManager
     */
    public function __construct(
        UserFactory $userFactory,
        UserRepository $userRepository,
        UserEventDispatcher $userEventDispatcher,
        ObjectManager $userObjectManager
    ) {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->userEventDispatcher = $userEventDispatcher;
        $this->userObjectManager = $userObjectManager;
    }

    /**
     * @param User $user
     * @param bool $flush
     *
     * @return UserManager
     */
    public function saveOne(User $user, bool $flush = true): UserManager
    {
        $this->userObjectManager->persist($user);
        if ($flush) {
            $this->userObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param array $users
     * @param bool  $flush
     *
     * @return UserManager
     */
    public function save(array $users, bool $flush = true): UserManager
    {
        foreach ($users as $user) {
            $this->saveOne($user, false);
        }
        if ($flush) {
            $this->userObjectManager->flush();
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return UserManager
     */
    public function create(User $user): UserManager
    {
        $this->saveOne($user);
        $this->userEventDispatcher->createdUserEvent($user);

        return $this;
    }

    /**
     * @param User $user
     *
     * @return UserManager
     */
    public function update(User $user): UserManager
    {
        $this->saveOne($user);
        $this->userEventDispatcher->updatedUserEvent($user);

        return $this;
    }

    public function removeOne(User $user, bool $flush = true): UserManager
    {
        $this->userObjectManager->remove($user);
        if ($flush) {
            $this->userObjectManager->flush();
        }

        return $this;
    }

    public function remove(array $users, bool $flush = true): UserManager
    {
        foreach ($users as $user) {
            $this->removeOne($user, false);
        }
        if ($flush) {
            $this->userObjectManager->flush();
        }

        return $this;
    }

    public function delete(User $user): UserManager
    {
        $this->removeOne($user);
        $this->userEventDispatcher->deletedUserEvent($user);

        return $this;
    }
}
