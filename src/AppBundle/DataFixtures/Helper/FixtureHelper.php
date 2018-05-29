<?php

namespace AppBundle\DataFixtures\Helper;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as Faker;
use Faker\Generator;

abstract class FixtureHelper extends Fixture
{
    const NB_PAGE = 2;
    const NB_PRICE = 3;
    const NB_PRICE_OFFER = 2;
    const NB_ZONE = 3;
    const NB_MENU = 5;

    /** @var Generator */
    public $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
}
