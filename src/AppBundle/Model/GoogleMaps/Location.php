<?php

namespace AppBundle\Model\GoogleMaps;

class Location
{
    /** @var string */
    private $lat;

    /** @var string */
    private $lng;

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function setLng(string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLng(): string
    {
        return $this->lng;
    }
}
