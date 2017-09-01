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
use AppBundle\Entity\User;
use AppBundle\Factory\UserFactory;
use Behat\Gherkin\Node\TableNode;

/**
 * Class UserContext.
 */
class UserContext extends DefaultContext
{
    /**
     * @Transform table:Username,Password,Email
     *
     * @param TableNode $table
     *
     * @return array
     */
    public function castTable(TableNode $table): array
    {
        /** @var UserFactory $userFactory */
        $userFactory = $user = $this->getService('arena.factory.user');

        $users = array();
        foreach ($table as $row) {
            /* @var User $user */
            $user = $userFactory->create($row['Username'], $row['Password'], $row['Email']);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * @Transform table:Username
     *
     * @param TableNode $table
     *
     * @return array
     */
    public function castUsernameTable(TableNode $table): array
    {
        /** @var UserFactory $userFactory */
        $userFactory = $user = $this->getService('arena.factory.user');

        $users = array();
        foreach ($table as $row) {
            $username = $row['Username'];
            $user = $userFactory->create($username, $username, $username.'@'.$username.'.com');

            $users[] = $user;
        }

        return $users;
    }

    /**
     * @Transform /^this user$/
     */
    public function castThisUser(): User
    {
        return $this->sharedStorage->get('user');
    }

    /**
     * @Transform :user
     *
     * @param $username
     *
     * @return User
     */
    public function castUsername(string $username): User
    {
        /** @var UserFactory $userFactory */
        $userFactory = $this->getService('arena.factory.user');

        return $userFactory->create($username, $username, $username.'@'.$username.'.com');
    }
}
