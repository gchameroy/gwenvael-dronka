<?php

class GoogleMapsCest
{
    public function tryGeoLocateAddress(UnitTester $I)
    {
        $gmaps = new \AppBundle\Utils\GoogleMaps();
        $location = $gmaps->geoLocateAddress('52800 Foulain, France');
        $I->assertNotNull($location);
        $I->assertEquals('48.038383', $location->getLat());
        $I->assertEquals('5.214517', $location->getLng());

        $gmaps = new \AppBundle\Utils\GoogleMaps();
        $location = $gmaps->geoLocateAddress('');
        $I->assertNull($location);
    }
}
