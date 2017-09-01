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
use AppBundle\Behat\Composition\SharedStorageTrait;
use AppBundle\Entity\Activity;
use AppBundle\Entity\Application;
use AppBundle\Entity\Sport;
use AppBundle\Entity\User;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behatch\Context\RestContext as BaseRestContext;

/**
 * Class RestContext.
 */
class RestContext extends BaseRestContext implements KernelAwareContext
{
    use KernelAwareTrait;
    use SharedStorageTrait;

    /**
     * @BeforeScenario
     */
    public function configureRequest()
    {
        $this->iAddHeaderEqualTo('Content-Type', 'application/ld+json');
        $this->iAddHeaderEqualTo('Accept', 'application/ld+json');
        $this->iAddHeaderEqualTo('Authorization', null);
    }

    /* User */

    /**
     * @Given /^(this user) is logged$/
     *
     * @param User $user
     */
    public function givenThisUserIsLogged(User $user)
    {
        $token = $this->getContainer()->get('lexik_jwt_authentication.jwt_manager')->create($user);

        $this->iAddHeaderEqualTo('Authorization', 'Bearer '.$token);
    }

    /**
     * @Given :user is logged
     *
     * @param User $user
     */
    public function givenIsLogged(User $user)
    {
        $token = $this->getContainer()->get('lexik_jwt_authentication.jwt_manager')->create($user);

        $this->iAddHeaderEqualTo('Authorization', 'Bearer '.$token);
    }

    /* Sport */

    /**
     * @When /^(?:this user|he|she|someone) wants to show the available sports$/
     */
    public function whenWantsToShowTheAvailableSports()
    {
        $this->iSendARequestTo('GET', '/sports');
    }

    /**
     * @When /^(?:this user|he|she|someone) searches sports by ([^"]*)$/
     *
     * @param string $search
     */
    public function whenSearchesSportBy(string $search)
    {
        $this->iSendARequestTo('GET', '/sports?name='.$search);
    }

    /**
     * @When /^(?:this user|he|she|someone) wants to show (this sport)$/
     *
     * @param Sport $sport
     */
    public function whenWantsToShowThisSport(Sport $sport)
    {
        $this->iSendARequestTo('GET', '/sports/'.$sport->getSlug());
    }

    /**
     * @When /^(?:this user|he|she|someone) wants to show an unknown sport$/
     */
    public function whenWantsToShowAnUnknownSport()
    {
        $this->iSendARequestTo('GET', '/sports/unknown');
    }

    /* Activity */

    /**
     * @When /^(?:this user|he|she|someone) wants to show the available activities$/
     */
    public function whenWantsToShowTheAvailableActivities()
    {
        $this->iSendARequestTo('GET', '/activities');
    }

    /**
     * @When /^(?:this user|he|she|someone) wants to show (this activity)$/
     *
     * @param Activity $activity
     */
    public function whenWantsToShowThisActivity(Activity $activity)
    {
        $this->iSendARequestTo('GET', '/activities/'.$activity->getId());
    }

    /**
     * @When /^(?:this user|he|she|someone) wants to show an unknown activity$/
     */
    public function whenWantsToShowAnUnknownActivity()
    {
        $this->iSendARequestTo('GET', '/activities/unknown');
    }

    /**
     * @When /^(?:this user|he|she|someone) creates a new activity:$/
     *
     * @param Activity $activity
     *
     * @internal param $Activity $
     * @internal param Sport $sport
     * @internal param $seats
     * @internal param $startsAt
     */
    public function whenCreatesANewActivity(Activity $activity)
    {
        $json = sprintf('{"title": "%s","seats": %d,"startsAt": "%s","sport": "/sports/%s"}',
            $activity->getTitle(),
            $activity->getSeats(),
            $activity->getStartsAt()->format('c'),
            $activity->getSport()->getId()
        );

        $this->iSendARequestTo('POST', '/activities', new PyStringNode([$json], 0));
    }
}
