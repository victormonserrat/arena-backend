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
use AppBundle\Entity\Notification;
use AppBundle\Event\AcceptedInvitationEvent;
use AppBundle\Factory\NotificationFactory;
use AppBundle\Services\NotificationManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class AcceptedInvitationSubscriber.
 */
class AcceptedInvitationSubscriber implements EventSubscriberInterface
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
     * @var NotificationFactory
     */
    private $notificationFactory;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * AcceptedInvitationSubscriber constructor.
     *
     * @param \Swift_Mailer       $mailer
     * @param EngineInterface     $engine
     * @param NotificationFactory $notificationFactory
     * @param NotificationManager $notificationManager
     */
    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $engine,
        NotificationFactory $notificationFactory,
        NotificationManager $notificationManager
    ) {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->notificationFactory = $notificationFactory;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ArenaEvents::ACCEPTED_INVITATION => array('acceptedInvitation'),
        ];
    }

    /**
     * @param AcceptedInvitationEvent $event
     */
    public function acceptedInvitation(AcceptedInvitationEvent $event)
    {
        $registration = $event->getRegistration();
        $activity = $registration->getActivity();
        $owner = $activity->getOwner();
        $user = $registration->getUser();

        $message = new \Swift_Message();
        $message
            ->setSubject('Solicitud acceptada')
            ->setFrom('noreplyarena.es@gmail.com')
            ->setTo($owner->getEmail())
            ->setBody(
                $this->engine->render(
                    'Emails/emails.html.twig',
                    [
                        'subject' => 'Invitación aceptada',
                        'body' => 'El usuario '.$user.' ha aceptado tu invitación en la actividad "'.$activity.'".',
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);

        $notification = $this->notificationFactory->create(Notification::ACCEPTANCE, $user, $activity);
        $this->notificationManager->create($notification);
    }
}
