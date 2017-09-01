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
use AppBundle\Entity\Activity;
use AppBundle\Entity\Registration;
use AppBundle\Event\DeletedSportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class DeletedSportSubscriber.
 */
class DeletedSportSubscriber implements EventSubscriberInterface
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
     * CreatedInvitationSubscriber constructor.
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
            ArenaEvents::DELETED_SPORT => array('deletedSport'),
        ];
    }

    /**
     * @param DeletedSportEvent $event
     */
    public function deletedSport(DeletedSportEvent $event)
    {
        $sport = $event->getSport();

        /** @var Activity $activity */
        foreach ($sport->getActivities() as $activity) {
            $owner = $activity->getOwner();

            $message = new \Swift_Message();
            $message
                ->setSubject('Deporte eliminado')
                ->setFrom('noreplyarena.es@gmail.com')
                ->setTo($owner->getEmail())
                ->setBody(
                    $this->engine->render(
                        'Emails/emails.html.twig',
                        [
                            'subject' => 'Deporte eliminado',
                            'body' => 'Ha sido eliminado el deporte "'.$sport.
                                '", por lo que tu actividad "'.$activity.'" ha sido eliminada.',
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
                    ->setSubject('Deporte eliminado')
                    ->setFrom('noreplyarena.es@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->engine->render(
                            'Emails/emails.html.twig',
                            [
                                'subject' => 'Deporte eliminado',
                                'body' => 'Ha sido eliminado el deporte "'.$sport.
                                    '", por lo que tu participación en la actividad "'.$activity.'" ha sido eliminada.',
                            ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }
    }
}
