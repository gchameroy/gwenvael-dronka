<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageBlockRepository")
 */
class PageBlock
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @var ArrayCollection|PageBlockImage[]
     *
     * @ORM\OneToMany(targetEntity="PageBlockImage", mappedBy="block", cascade={"remove"})
     */
    private $images;

    /**
     * @var PageBlockAction
     *
     * @ORM\ManyToOne(targetEntity="PageBlockAction")
     */
    private $action;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="blocks")
     */
    private $page;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage(PageBlockImage $image): self
    {
        $this->images[] = $image;

        return $this;
    }

    public function removeImage(PageBlockImage $image): self
    {
        return $this->images->removeElement($image);
    }

    public function setAction(PageBlockAction $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ?PageBlockAction
    {
        return $this->action;
    }

    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): Page
    {
        return $this->page;
    }
}
