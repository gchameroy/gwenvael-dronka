<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     */
    private $titleSeo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000, nullable=true)
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
}
