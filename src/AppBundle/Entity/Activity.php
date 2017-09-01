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

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity.
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivityRepository")
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={
 *              "groups"={"read_activity"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"write_activity"}
 *          },
 *     },
 * )
 */
class Activity
{
    /**
     * Status.
     */
    const NOT_LOGGED = 'not_logged';
    const OWNER = 'owner';
    const REGISTERED = 'registered';
    const APPLICANT = 'applicant';
    const INVITED = 'invited';
    const LOGGED = 'logged';

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
     * @ORM\Column(name="title", type="string", length=255)
     * @Groups({"read_activity", "write_activity"})
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starts_at", type="datetime")
     * @Groups({"read_activity", "write_activity"})
     * @Assert\NotBlank()
     * @Assert\Date()
     * @Assert\GreaterThan("now")
     */
    private $startsAt;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     * @Groups({"read_activity", "write_activity"})
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     * @Groups({"read_activity", "write_activity"})
     * @Assert\Length(max="255")
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"read_activity", "write_activity"})
     * @Assert\Length(max="500")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="seats", type="integer", nullable=true)
     * @Groups({"read_activity", "write_activity"})
     * @Assert\GreaterThan(0)
     */
    private $seats;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Registration", mappedBy="activity")
     * @Groups({"involved"})
     */
    private $registrations;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="activity")
     */
    private $notifications;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups({"read_activity"})
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private $owner;

    /**
     * @var Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups({"read_activity", "write_activity"})
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private $sport;

    /**
     * @var string
     *
     * @Groups({"read_activity"})
     */
    private $status;

    /**
     * Activity constructor.
     */
    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * Get id.
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Activity
     */
    public function setTitle(string $title): Activity
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set location.
     *
     * @param string $location
     *
     * @return Activity
     */
    public function setLocation(string $location): Activity
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Activity
     */
    public function setDescription(string $description): Activity
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set seats.
     *
     * @param int $seats
     *
     * @return Activity
     */
    public function setSeats(int $seats): Activity
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * Get seats.
     *
     * @return int
     */
    public function getSeats(): ?int
    {
        return $this->seats;
    }

    /**
     * Set startsAt.
     *
     * @param \DateTimeInterface $startsAt
     *
     * @return Activity
     */
    public function setStartsAt(\DateTimeInterface $startsAt): Activity
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt.
     *
     * @return \DateTimeInterface
     */
    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    /**
     * Set duration.
     *
     * @param int $duration
     *
     * @return Activity
     */
    public function setDuration(int $duration): Activity
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration.
     *
     * @return int
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * Add registration.
     *
     * @param Registration $registration
     *
     * @return Activity
     */
    public function addRegistration(Registration $registration): Activity
    {
        $this->registrations[] = $registration;

        return $this;
    }

    /**
     * Remove registration.
     *
     * @param Registration $registration
     *
     * @return Activity
     */
    public function removeRegistration(Registration $registration): Activity
    {
        $this->registrations->removeElement($registration);

        return $this;
    }

    /**
     * Get registrations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    /**
     * Add notification.
     *
     * @param Notification $notification
     *
     * @return Activity
     */
    public function addNotification(Notification $notification): Activity
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param Notification $notification
     *
     * @return Activity
     */
    public function removeNotification(Notification $notification): Activity
    {
        $this->notifications->removeElement($notification);

        return $this;
    }

    /**
     * Get notifications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    /**
     * Get accepted registrations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcceptedRegistrations(): Collection
    {
        return $this->registrations->filter(function ($registration) {
            /* @var Registration $registration */
            return $registration->isAccepted();
        });
    }

    /**
     * Get applications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications(): Collection
    {
        return $this->registrations->filter(function ($registration) {
            /* @var Registration $registration */
            return $registration->isApplication();
        });
    }

    /**
     * Get invitations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitations(): Collection
    {
        return $this->registrations->filter(function ($registration) {
            /* @var Registration $registration */
            return $registration->isInvitation();
        });
    }

    /**
     * Set owner.
     *
     * @param User $owner
     *
     * @return Activity
     */
    public function setOwner(User $owner): Activity
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner.
     *
     * @return User
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * Set sport.
     *
     * @param Sport $sport
     *
     * @return Activity
     */
    public function setSport(Sport $sport): Activity
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport.
     *
     * @return Sport
     */
    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Activity
     */
    public function setStatus(string $status): Activity
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Activity
     */
    public function setStatusWithUser(User $user): Activity
    {
        if ($this->getOwner()->getId() === $user->getId()) {
            $this->setStatus(self::OWNER);
        } else {
            $registrations = $this->getRegistrations()->filter(function ($registration) use ($user) {
                /* @var Registration $registration */
                return $registration->getUser()->getId() === $user->getId()
                    && !$registration->isRefused();
            });

            if ($registrations->isEmpty()) {
                $this->setStatus(self::LOGGED);
            } else {
                /** @var Registration $registration */
                $registration = $registrations->first();

                if ($registration->isAccepted()) {
                    $this->setStatus(self::REGISTERED);
                } elseif ($registration->isApplication()) {
                    $this->setStatus(self::APPLICANT);
                } else {
                    $this->setStatus(self::INVITED);
                }
            }
        }

        return $this;
    }

    /**
     * @Groups({"read_activity"})
     *
     * @return int
     */
    public function getAcceptedRegistrationsCount(): int
    {
        return count($this->getAcceptedRegistrations());
    }

    /**
     * @return bool
     */
    public function isFuture(): bool
    {
        return $this->getStartsAt() > new \DateTime('now');
    }
}
