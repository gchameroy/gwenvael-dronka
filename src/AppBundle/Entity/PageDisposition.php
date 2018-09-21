<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PageDisposition
 *
 * @ORM\Table(name="page_disposition")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageDispositionRepository")
 */
class PageDisposition
{
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;

    /**
     * @var ArrayCollection|Page[]
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="disposition")
     */
    private $pages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return PageDisposition
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return PageDisposition
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Add page.
     *
     * @param Page $page
     *
     * @return PageDisposition
     */
    public function addPage(Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page.
     *
     * @param Page $page
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePage(Page $page)
    {
        return $this->pages->removeElement($page);
    }

    /**
     * Get pages.
     *
     * @return ArrayCollection|Page[]
     */
    public function getPages()
    {
        return $this->pages;
    }
}
