<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page
{
    use Image;

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
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Titre invalide (trop long)"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
    private $titleSeo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Description invalide (trop long)"
     * )
     */
    private $descriptionSeo;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $deletable;

    /**
     * @var ArrayCollection|PageBlock[]
     *
     * @ORM\OneToMany(targetEntity="PageBlock", mappedBy="page", cascade={"remove"})
    */
    private $blocks;

    /**
     * @var PageDisposition
     *
     * @ORM\ManyToOne(targetEntity="PageDisposition", inversedBy="page")
     * @ORM\JoinColumn(nullable=false)
     */
    private $disposition;

    public function __construct()
    {
        $this->deletable = true;
        $this->blocks = new ArrayCollection();
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

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setTitleSeo(?string $titleSeo): self
    {
        $this->titleSeo = $titleSeo;

        return $this;
    }

    public function getTitleSeo(): ?string
    {
        return $this->titleSeo;
    }

    public function setDescriptionSeo(?string $descriptionSeo): self
    {
        $this->descriptionSeo = $descriptionSeo;

        return $this;
    }

    public function getDescriptionSeo(): ?string
    {
        return $this->descriptionSeo;
    }

    public function setDeletable(bool $deletable): self
    {
        $this->deletable = $deletable;

        return $this;
    }

    public function isDeletable(): bool
    {
        return $this->deletable;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function addBlock(PageBlock $block): self
    {
        $this->blocks[] = $block;

        return $this;
    }

    public function removeBlock(PageBlock $block): self
    {
        return $this->blocks->removeElement($block);
    }

    /**
     * Get deletable.
     *
     * @return bool
     */
    public function getDeletable()
    {
        return $this->deletable;
    }

    /**
     * Set disposition.
     *
     * @param PageDisposition|null $disposition
     *
     * @return Page
     */
    public function setDisposition(PageDisposition $disposition = null)
    {
        $this->disposition = $disposition;

        return $this;
    }

    /**
     * Get disposition.
     *
     * @return PageDisposition|null
     */
    public function getDisposition()
    {
        return $this->disposition;
    }
}
