<?php

namespace AppBundle\DataFixtures\Helper;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as Faker;
use Faker\Generator;

abstract class FixtureHelper extends Fixture
{
    const NB_PAGE = 5;
    const NB_PRICE = 3;
    const NB_PRICE_OFFER = 2;

    /** @var Generator */
    public $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
}
