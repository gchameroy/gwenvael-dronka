<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialNetworkRepository")
 */
class SocialNetwork
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    public function getId(): int
    {
        return $this->id;
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

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
