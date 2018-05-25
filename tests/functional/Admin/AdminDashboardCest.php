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
}
