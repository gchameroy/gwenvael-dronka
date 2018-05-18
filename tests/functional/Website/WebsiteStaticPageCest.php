<?php

use Codeception\Util\HttpCode;

class WebsiteStaticPageCest
{
    public function tryHome(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Gwenvael Dronka', 'h1');
        $I->see('Une méthode douce d\'éducation canine', 'h4');
    }

    public function tryPrices(FunctionalTester $I)
    {
        $I->amOnPage('/tarifs');
        $I->seeCurrentUrlEquals('/tarifs');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Tarifs', 'h2');
    }

    public function trySites(FunctionalTester $I)
    {
        $I->amOnPage('/sites');
        $I->seeCurrentUrlEquals('/sites');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Sites', 'h2');
    }

    public function tryLessons(FunctionalTester $I)
    {
        $I->amOnPage('/cours');
        $I->seeCurrentUrlEquals('/cours');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Nos Cours', 'h2');
    }
}
