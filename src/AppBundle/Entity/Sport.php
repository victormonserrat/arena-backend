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

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sport.
 *
 * @ORM\Table(name="sport")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SportRepository")
 * @ApiResource(
 *     attributes={
 *          "filters"={"sport.search"},
 *          "normalization_context"={
 *              "groups"={"read_sport"}
 *          },
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "path"="/sports/{id}"},
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "path"="/sports"},
 *     },
 * )
 */
class Sport
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     * @ApiProperty(identifier=false)
     * @Groups({"read_activity"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @ApiProperty(identifier=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Groups({"read_sport", "read_activity"})
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"read_sport"})
     * @Assert\Length(max="500")
     */
    private $description;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Activity", mappedBy="sport")
     */
    private $activities;

    /**
     * Sport constructor.
     */
    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
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
     * Get slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Sport
     */
    public function setSlug($slug): Sport
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Sport
     */
    public function setName(string $name): Sport
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Sport
     */
    public function setDescription(string $description): Sport
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
     * Add activity.
     *
     * @param Activity $activity
     *
     * @return Sport
     */
    public function addActivity(Activity $activity): Sport
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity.
     *
     * @param Activity $activity
     *
     * @return Sport
     */
    public function removeActivity(Activity $activity): Sport
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
        return $this->activities;
    }
}
