<?php

namespace AppBundle\Behat\Context\Hook;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Sport;
use Behatch\Context\JsonContext as BaseJsonContext;

/**
 * Class JsonContext.
 */
class JsonContext extends BaseJsonContext
{
    /**
     * @Then /^(?:this user|he|she|someone) sees (\d+)$/
     *
     * @param int $count
     */
    public function thenSees(int $count)
    {
        $this->assertSession()->statusCodeEquals(200);
        $this->theResponseShouldBeInJson();
        $this->theJsonNodeShouldBeEqualToTheNumber('hydra:totalItems', $count);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that is created$/
     */
    public function thenSeesThatIsCreated()
    {
        $this->assertSession()->statusCodeEquals(201);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees no content but success$/
     */
    public function thenSeesNoContentButSuccess()
    {
        $this->assertSession()->statusCodeEquals(204);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that is a bad request$/
     */
    public function thenSeesThatIsABadRequest()
    {
        $this->assertSession()->statusCodeEquals(400);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that is unauthorized$/
     */
    public function thenSeesThatIsUnauthorized()
    {
        $this->assertSession()->statusCodeEquals(401);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that is forbidden$/
     */
    public function thenSeesThatIsForbidden()
    {
        $this->assertSession()->statusCodeEquals(403);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that could not be found$/
     */
    public function thenSeesThatCouldNotBeFound()
    {
        $this->assertSession()->statusCodeEquals(404);
    }

    /**
     * @Then /^(?:this user|he|she|someone) sees that is gone$/
     */
    public function thenSeesThatIsGone()
    {
        $this->assertSession()->statusCodeEquals(410);
    }

    /* Sport */

    /**
     * @Then /^(?:this user|he|she|someone) sees (this sport)$/
     *
     * @param Sport $sport
     */
    public function thenSeesThisSport(Sport $sport)
    {
        $this->assertSession()->statusCodeEquals(200);
        $this->theResponseShouldBeInJson();
        $this->theJsonNodeShouldBeEqualTo('@id', '/sports/'.$sport->getSlug());
    }

    /* Activity */

    /**
     * @Then /^(?:this user|he|she|someone) sees (this activity)$/
     *
     * @param Activity $activity
     */
    public function thenSeesThisActivity(Activity $activity)
    {
        $this->assertSession()->statusCodeEquals(200);
        $this->theResponseShouldBeInJson();
        $this->theJsonNodeShouldBeEqualTo('id', $activity->getId());
    }
}
