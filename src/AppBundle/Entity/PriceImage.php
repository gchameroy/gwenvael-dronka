<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceImageRepository")
 */
class PriceImage implements ImageInterface
{
    use ImageTrait;

    /**
     * @var Price
     *
     * @ORM\ManyToOne(targetEntity="Price", inversedBy="images")
     */
    private $price;

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
