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
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={
 *              "groups"={"read_user"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"update_user"}
 *          },
 *     },
 * )
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @Groups({"read_user", "update_user", "read_activity", "involved", "read_registration"})
     *
     * @ORM\Column(name="full_name", type="string", nullable=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @Groups({"read_user", "read_activity"})
     */
    protected $email;

    /**
     * @var string
     *
     * @Groups({"read_user", "read_activity", "involved", "read_registration"})
     *
     * @ORM\Column(name="avatar", type="string", nullable=true)
     */
    private $avatar;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Registration", mappedBy="user")
     */
    private $registrations;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Activity", mappedBy="owner");
     */
    private $activities;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user")
     */
    private $notifications;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Communication", mappedBy="user")
     */
    private $communications;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->registrations = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->communications = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getEmail();
    }

    /**
     * Get id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get fullName.
     *
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * Set fullName.
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName(string $fullName): User
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Set avatar.
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar(string $avatar): User
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Add registration.
     *
     * @param Registration $registration
     *
     * @return User
     */
    public function addRegistration(Registration $registration): User
    {
        $this->registrations[] = $registration;

        return $this;
    }

    /**
     * Remove registration.
     *
     * @param Registration $registration
     *
     * @return User
     */
    public function removeRegistration(Registration $registration): User
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
     * Get accepted registrations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcceptedRegistrations(): Collection
    {
        return $this->registrations->filter(function ($registration) {
            /* @var Registration $registration */
            return $registration->isAccepted() && $registration->getActivity()->isFuture();
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
            return $registration->isApplication() && $registration->getActivity()->isFuture();
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
            return $registration->isInvitation() && $registration->getActivity()->isFuture();
        });
    }

    /**
     * Add activity.
     *
     * @param Activity $activity
     *
     * @return User
     */
    public function addActivity(Activity $activity): User
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity.
     *
     * @param Activity $activity
     *
     * @return User
     */
    public function removeActivity(Activity $activity): User
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    /**
     * Get activities.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivities(): Collection
    {
        return $this->activities->filter(function ($activity) {
            /* @var Activity $activity */
            return $activity->isFuture();
        });
    }

    /**
     * Add notification.
     *
     * @param Notification $notification
     *
     * @return User
     */
    public function addNotification(Notification $notification): User
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param Notification $notification
     *
     * @return User
     */
    public function removeNotification(Notification $notification): User
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
     * Add communication.
     *
     * @param Communication $communication
     *
     * @return User
     */
    public function addCommunication(Communication $communication): User
    {
        $this->communications[] = $communication;

        return $this;
    }

    /**
     * Remove communication.
     *
     * @param Communication $communication
     *
     * @return User
     */
    public function removeCommunication(Communication $communication): User
    {
        $this->communications->removeElement($communication);

        return $this;
    }

    /**
     * Get communications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommunications(): Collection
    {
        return $this->communications;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }
}
