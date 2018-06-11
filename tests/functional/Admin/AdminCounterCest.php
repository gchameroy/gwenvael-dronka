<?php

use Codeception\Util\HttpCode;

class AdminCounterCest
{
    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('', '.widget-counter a');

        $I->click('', '.widget-counter a');
        $I->seeCurrentUrlEquals('/admin/counters/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'setting_counter[value]' => 119,
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin');
        $I->see('119', '.widget-counter a');
    }
}
