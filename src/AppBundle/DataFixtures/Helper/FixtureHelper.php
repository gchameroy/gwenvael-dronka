<?php

namespace AppBundle\DataFixtures\Helper;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as Faker;
use Faker\Generator;

abstract class FixtureHelper extends Fixture
{
    const NB_PAGE = 2;
    const NB_PAGE_DISPOSITION = 3;
    const NB_PAGE_BLOCK = 3;
    const NB_PAGE_BLOCK_ACTION = 3;
    const NB_PAGE_BLOCK_IMAGE = 3;
    const NB_PAGE_STATIC = 3;
    const NB_PRICE = 3;
    const NB_OFFER = 2;
    const NB_PRICE_IMAGE = 3;
    const NB_ZONE = 3;
    const NB_MENU = 5;
    const NB_SOCIAL_NETWORK = 8;
    const NB_SETTING_SOCIAL_NETWORK = 3;
    const NB_COUNTER = 4;

    /** @var Generator */
    public $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
}
