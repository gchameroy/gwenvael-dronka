<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingSocialNetworkRepository")
 */
class SettingSocialNetwork
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
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Url(
     *     protocols = {"http", "https"},
     *     message = "Url invalide."
     * )
     */
    private $url;

    /**
     * @var Setting
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Setting", inversedBy="socialNetworks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $setting;

    /**
     * @var SocialNetwork
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SocialNetwork")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socialNetwork;

    public function getId(): int
    {
        return $this->id;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setSetting(Setting $setting): self
    {
        $this->setting = $setting;

        return $this;
    }

    public function getSetting(): Setting
    {
        return $this->setting;
    }

    public function setSocialNetwork(SocialNetwork $socialNetwork): self
    {
        $this->socialNetwork = $socialNetwork;

        return $this;
    }

    public function getSocialNetwork(): ?SocialNetwork
    {
        return $this->socialNetwork;
    }
}
