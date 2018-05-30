<?php

use Codeception\Util\HttpCode;

class AdminDashboardCest
{
    public function tryHome(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Dashboard', 'h2');
    }

    public function tryViewWebsite(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('Voir le site', '.navbar-top-links a');
        $I->click('Voir le site', '.navbar-top-links a');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
