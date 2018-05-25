<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceRepository")
 */
class Price
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="25",
     *     minMessage="Titre invalide (trop court)",
     *     maxMessage="Titre invalide (trop long)"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="25",
     *     minMessage="Label invalide (trop court)",
     *     maxMessage="Label invalide (trop long)"
     * )
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     *
     * @Assert\Range(
     *     min = 0,
     *     max = 2500,
     *     minMessage = "Prix invalide (doit être supérieur à {{ limit }})",
     *     maxMessage = "Prix invalide (doit être inférieur à {{ limit }})"
     * )
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $offer;

    public function __construct()
    {
        $this->offer = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setOffer(bool $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function isOffer(): float
    {
        return $this->offer;
    }
}
