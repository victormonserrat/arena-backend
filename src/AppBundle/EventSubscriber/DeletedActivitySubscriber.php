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

use AppBundle\ArenaEvents;
use AppBundle\Entity\Registration;
use AppBundle\Event\DeletedActivityEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class DeletedActivitySubscriber.
 */
class DeletedActivitySubscriber implements EventSubscriberInterface
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
     * DeletedActivitySubscriber constructor.
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
            ArenaEvents::DELETED_ACTIVITY => 'deletedActivity',
        ];
    }

    /**
     * @param DeletedActivityEvent $event
     */
    public function deletedActivity(DeletedActivityEvent $event)
    {
        $activity = $event->getActivity();
        $owner = $activity->getOwner();

        $message = new \Swift_Message();
        $message
            ->setSubject('Actividad eliminada')
            ->setFrom('noreplyarena.es@gmail.com')
            ->setTo($owner->getEmail())
            ->setBody(
                $this->engine->render(
                    'Emails/emails.html.twig',
                    [
                        'subject' => 'Actividad eliminada',
                        'body' => 'La actividad "'.$activity->getTitle().'" ha sido eliminada.',
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);

        /** @var Registration $acceptedRegistration */
        foreach ($activity->getAcceptedRegistrations() as $acceptedRegistration) {
            $user = $acceptedRegistration->getUser();

            $message = new \Swift_Message();
            $message
                ->setSubject('Actividad eliminada')
                ->setFrom('noreplyarena.es@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->engine->render(
                        'Emails/emails.html.twig',
                        [
                            'subject' => 'Actividad eliminada',
                            'body' => 'La actividad "'.$activity.'" donde participas ha sido eliminada.',
                        ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
        }
    }
}
