<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingCounterRepository")
 */
class SettingCounter
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
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Range(
     *     min = 0,
     *     max = 500000,
     *     minMessage = "Valeur invalide (doit être supérieur à {{ limit }})",
     *     maxMessage = "Valeur invalide (doit être inférieur à {{ limit }})",
     * )
     */
    private $value;

    /**
     * @var Setting
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Setting")
     * @ORM\JoinColumn(nullable=false)
     */
    private $setting;

    /**
     * @var Counter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Counter")
     * @ORM\JoinColumn(nullable=false)
     */
    private $counter;

    public function getId(): int
    {
        return $this->id;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
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

    public function setCounter(Counter $counter): self
    {
        $this->counter = $counter;

        return $this;
    }

    public function getCounter(): ?Counter
    {
        return $this->counter;
    }
}
