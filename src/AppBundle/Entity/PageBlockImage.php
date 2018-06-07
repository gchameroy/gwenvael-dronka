<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageBlockImageRepository")
 */
class PageBlockImage implements ImageInterface
{
    use ImageTrait;

    const FOLDER = 'page-block-image';

    /**
     * @var PageBlock
     *
     * @ORM\ManyToOne(targetEntity="PageBlock", inversedBy="images")
     */
    private $block;

    public function setBlock(PageBlock $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getBlock(): PageBlock
    {
        return $this->block;
    }
}
