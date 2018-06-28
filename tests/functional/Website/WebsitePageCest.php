<?php

use AppBundle\DataFixtures\Helper\FixtureHelper;
use Codeception\Util\HttpCode;

class WebsitePageCest
{
    public function tryView(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->see('Troubles', 'a');

        $I->amOnPage('/troubles');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/troubles');

        $I->seeNumberOfElements('.row-block', FixtureHelper::NB_PAGE_BLOCK);
    }
}
