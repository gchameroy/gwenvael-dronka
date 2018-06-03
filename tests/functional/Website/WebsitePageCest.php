<?php

use AppBundle\DataFixtures\Helper\FixtureHelper;
use Codeception\Util\HttpCode;

class WebsitePageCest
{
    public function tryView(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->see('Cours', 'a');

        $I->amOnPage('/cours');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/cours');

        $I->seeNumberOfElements('.row-block', FixtureHelper::NB_PAGE_BLOCK);
    }
}
