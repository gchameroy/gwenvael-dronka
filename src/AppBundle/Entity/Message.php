<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    use Timestampable;

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
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="100",
     *     minMessage="Nom invalide (trop court)",
     *     maxMessage="Nom invalide (trop long)"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     * @Assert\Email(
     *     message="Email invalide"
     * )
     * @Assert\Length(
     *     max="150",
     *     maxMessage="Email invalide"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     * @Assert\Length(
     *     max="100",
     *     maxMessage="Objet invalide (trop long)"
     * )
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     message="Champ obligatoire"
     * )
     */
    private $message;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
