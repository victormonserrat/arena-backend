<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notification.
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * Type.
     */
    const APPLICATION = 'application';
    const INVITATION = 'invitation';
    const ACCEPTANCE = 'acceptance';
    const REJECTION = 'rejection';

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_at", type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $sentAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @var Activity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private $activity;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->setSentAt(new \DateTime('now'));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUser().$this->getActivity();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Notification
     */
    public function setType(string $type): Notification
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt(): \DateTime
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime $sentAt
     *
     * @return Notification
     */
    public function setSentAt(\DateTime $sentAt): Notification
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Notification
     */
    public function setUser(User $user): Notification
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     *
     * @return Notification
     */
    public function setActivity(Activity $activity): Notification
    {
        $this->activity = $activity;

        return $this;
    }
}
