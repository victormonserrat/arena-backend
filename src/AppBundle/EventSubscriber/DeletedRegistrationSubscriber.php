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
use AppBundle\Event\DeletedRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class DeletedRegistrationSubscriber.
 */
class DeletedRegistrationSubscriber implements EventSubscriberInterface
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
     * DeletedRegistrationSubscriber constructor.
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
            ArenaEvents::DELETED_REGISTRATION => array('deletedRegistration'),
        ];
    }

    /**
     * @param DeletedRegistrationEvent $event
     */
    public function deletedRegistration(DeletedRegistrationEvent $event)
    {
        $registration = $event->getRegistration();
        $activity = $registration->getActivity();
        $user = $registration->getUser();
        $owner = $activity->getOwner();

        if ($registration->getStatus() === Registration::ACCEPTED) {
            $message = new \Swift_Message();
            $message
                ->setSubject('Participación eliminada')
                ->setFrom('noreplyarena.es@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->engine->render(
                        'Emails/emails.html.twig',
                        [
                            'subject' => 'Participación eliminada',
                            'body' => 'Tu participación en la actividad "'.$activity.'" ha sido eliminada.',
                        ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);

            $message = new \Swift_Message();
            $message
                ->setSubject('Participación eliminada')
                ->setFrom('noreplyarena.es@gmail.com')
                ->setTo($owner->getEmail())
                ->setBody(
                    $this->engine->render(
                        'Emails/emails.html.twig',
                        [
                            'subject' => 'Participación eliminada',
                            'body' => 'La participación de '.$user.' en la actividad "'.$activity.'" ha sido eliminada.',
                        ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
        } else {
            if ($registration->getType() === Registration::APPLICATION) {
                $message = new \Swift_Message();
                $message
                    ->setSubject('Solicitud eliminada')
                    ->setFrom('noreplyarena.es@gmail.com')
                    ->setTo($owner->getEmail())
                    ->setBody(
                        $this->engine->render(
                            'Emails/emails.html.twig',
                            [
                                'subject' => 'Solicitud eliminada',
                                'body' => 'La solicitud de '.$user.' en la actividad "'.$activity.'" ha sido eliminada.',
                            ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
            } else {
                $message = new \Swift_Message();
                $message
                    ->setSubject('Invitación eliminada')
                    ->setFrom('noreplyarena.es@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->engine->render(
                            'Emails/emails.html.twig',
                            [
                                'subject' => 'Invitación eliminada',
                                'body' => 'Tu invitación en la actividad "'.$activity.'" ha sido eliminada.',
                            ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }
    }
}
