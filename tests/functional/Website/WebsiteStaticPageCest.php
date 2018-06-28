<?php

use AppBundle\DataFixtures\Helper\FixtureHelper;
use Codeception\Util\HttpCode;

class WebsiteStaticPageCest
{
    public function tryHome(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/');

        $I->seeNumberOfElements('.social li', FixtureHelper::NB_SETTING_SOCIAL_NETWORK);
        $I->seeNumberOfElements('.nav-menu li', FixtureHelper::NB_MENU);
        $I->seeNumberOfElements('.nav-menu li', FixtureHelper::NB_MENU);
        $I->seeNumberOfElements('#counter .counter', FixtureHelper::NB_COUNTER);
        $I->seeNumberOfElements('#section-lesson .lesson', FixtureHelper::NB_PAGE_BLOCK);
    }

    public function tryPrices(FunctionalTester $I)
    {
        $I->amOnPage('/tarifs');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/tarifs');

        $I->seeNumberOfElements('.row-price', FixtureHelper::NB_PRICE);
        $I->seeNumberOfElements('.row-offers .col-price', FixtureHelper::NB_OFFER);
    }
}
