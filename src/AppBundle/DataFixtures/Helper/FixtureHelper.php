<?php

namespace AppBundle\DataFixtures\Helper;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as Faker;

abstract class FixtureHelper extends Fixture
{
    const NB_PAGE = 5;

    /** @var \Faker\Generator */
    public $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
}
