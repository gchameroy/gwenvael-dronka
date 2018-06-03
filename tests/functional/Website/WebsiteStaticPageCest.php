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
        $I->see('Une méthode douce', 'h1');
        $I->see('D\'éducation canine', 'h2');
        $I->seeNumberOfElements('.social li', FixtureHelper::NB_SETTING_SOCIAL_NETWORK);
        $I->seeNumberOfElements('.nav-menu li', FixtureHelper::NB_MENU);
    }

    public function tryPrices(FunctionalTester $I)
    {
        $I->amOnPage('/tarifs');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/tarifs');
        $I->see('Tarifs', 'h2');
        $I->see('Tarifs', 'h3');
        $I->seeNumberOfElements('#box-prices .Pricing-box', FixtureHelper::NB_PRICE);
        $I->see('Offres combinées', 'h3');
        $I->seeNumberOfElements('#box-offers .Pricing-box', FixtureHelper::NB_PRICE_OFFER);
    }

    public function trySites(FunctionalTester $I)
    {
        $I->amOnPage('/sites');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/sites');
        $I->see('Sites', 'h2');
    }

    public function tryLessons(FunctionalTester $I)
    {
        $I->amOnPage('/cours');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/cours');
        $I->see('Nos Cours', 'h2');
    }
}
