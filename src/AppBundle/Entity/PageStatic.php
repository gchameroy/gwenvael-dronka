<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageStaticRepository")
 */
class PageStatic
{
    const PAGE_HOME = 1;
    const PAGE_PRICE = 2;
    const PAGE_CONTACT = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Titre invalide (trop long)"
     * )
     */
    private $titleSEO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     max="1000",
     *     maxMessage="Description invalide (trop long)"
     * )
     */
    private $descriptionSEO;

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitleSEO(?string $titleSEO): self
    {
        $this->titleSEO = $titleSEO;

        return $this;
    }

    public function getTitleSEO(): ?string
    {
        return $this->titleSEO;
    }

    public function setDescriptionSEO(?string $descriptionSEO): self
    {
        $this->descriptionSEO = $descriptionSEO;

        return $this;
    }

    public function getDescriptionSEO(): ?string
    {
        return $this->descriptionSEO;
    }
}
