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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Registration.
 *
 * @ORM\Table(name="registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistrationRepository")
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={
 *              "groups"={"read_registration"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"write_registration"}
 *          },
 *     },
 * )
 */
class Registration
{
    /**
     * Type.
     */
    const APPLICATION = 'application';
    const INVITATION = 'invitation';

    /**
     * Status.
     */
    const ACCEPTED = 'accepted';
    const REFUSED = 'refused';
    const WAITING = 'waiting';

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
     * @Groups({"involved", "read_registration"})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     * @Assert\NotBlank()
     * @Groups({"involved", "read_registration"})
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $createdAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     * @Assert\NotBlank()
     *
     * @Groups({"read_activity", "involved", "read_registration", "write_registration"})
     */
    private $user;

    /**
     * @var Activity
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity", inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     * @Assert\NotBlank()
     *
     * @Groups({"write_registration"})
     */
    private $activity;

    /**
     * Registration constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime('now'));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUser().$this->getActivity();
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
     * Get type.
     *
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): Registration
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus(string $status): Registration
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTimeInterface $createdAt
     *
     * @return Registration
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): Registration
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Registration
     */
    public function setUser(User $user): Registration
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set activity.
     *
     * @param Activity $activity
     *
     * @return Registration
     */
    public function setActivity(Activity $activity): Registration
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity.
     *
     * @return Activity
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->getStatus() === self::ACCEPTED;
    }

    /**
     * @return bool
     */
    public function isRefused(): bool
    {
        return $this->getStatus() === self::REFUSED;
    }

    /**
     * @return bool
     */
    public function isApplication(): bool
    {
        return $this->getStatus() === self::WAITING && $this->getType() === self::APPLICATION;
    }

    /**
     * @return bool
     */
    public function isInvitation(): bool
    {
        return $this->getStatus() === self::WAITING && $this->getType() === self::INVITATION;
    }
}
