<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use AppBundle\Entity\Activity;
use AppBundle\Security\Voter\ActivityVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ActivityContextBuilder.
 */
final class ActivityContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * @var SerializerContextBuilderInterface
     */
    private $decorated;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * ActivityContextBuilder constructor.
     *
     * @param SerializerContextBuilderInterface $decorated
     * @param AuthorizationCheckerInterface     $authorizationChecker
     */
    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Request    $request
     * @param bool       $normalization
     * @param array|null $extractedAttributes
     *
     * @return array
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $subject = $request->attributes->get('data');

        if (
            $subject instanceof Activity
            && $this->authorizationChecker->isGranted(ActivityVoter::READ_REGISTRATIONS, $subject)
        ) {
            $context['groups'][] = 'involved';
        }

        return $context;
    }
}
