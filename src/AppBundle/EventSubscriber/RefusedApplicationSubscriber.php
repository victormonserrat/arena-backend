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
use AppBundle\Event\RefusedApplicationEvent;
use AppBundle\Factory\NotificationFactory;
use AppBundle\Services\NotificationManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class RefusedApplicationSubscriber.
 */
class RefusedApplicationSubscriber implements EventSubscriberInterface
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
     * RefusedApplicationSubscriber constructor.
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
            ArenaEvents::REFUSED_APPLICATION => array('refusedApplication'),
        ];
    }

    /**
     * @param RefusedApplicationEvent $event
     */
    public function refusedApplication(RefusedApplicationEvent $event)
    {
        $registration = $event->getRegistration();
        $activity = $registration->getActivity();
        $user = $registration->getUser();

        $message = new \Swift_Message();
        $message
            ->setSubject('Solicitud rechazada')
            ->setFrom('noreplyarena.es@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->engine->render(
                    'Emails/emails.html.twig',
                    [
                        'subject' => 'Solicitud rechazada',
                        'body' => 'Tu solicitud de participación en la actividad "'.$activity.'" ha sido rechazada.',
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);

        $notification = $this->notificationFactory->create(Notification::REJECTION, $user, $activity);
        $this->notificationManager->create($notification);
    }
}
