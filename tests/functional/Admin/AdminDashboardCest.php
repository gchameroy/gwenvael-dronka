<?php

use Codeception\Util\HttpCode;

class AdminDashboardCest
{
    public function tryHome(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin');
    }

    public function tryViewWebsite(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('Voir le site', '.navbar-top-links a');

        $I->click('Voir le site', '.navbar-top-links a');
        $I->seeCurrentUrlEquals('/');
    }
}
