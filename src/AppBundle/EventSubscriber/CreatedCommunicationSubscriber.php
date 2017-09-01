<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Communication;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class CreatedCommunicationSubscriber.
 */
class CreatedCommunicationSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CreatedCommunicationSubscriber constructor.
     *
     * @param \Swift_Mailer   $mailer
     * @param EngineInterface $engine
     */
    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $engine
    ) {
        $this->mailer = $mailer;
        $this->engine = $engine;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'easy_admin.post_persist' => array('createdCommunication'),
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function createdCommunication(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Communication)) {
            return;
        }

        $user = $entity->getUser();

        $message = new \Swift_Message();
        $message
            ->setSubject($entity->getSubject())
            ->setFrom('noreplyarena.es@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->engine->render(
                    'Emails/emails.html.twig',
                    [
                        'subject' => $entity->getSubject(),
                        'body' => $entity->getBody(),
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
