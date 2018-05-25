<?php

use Codeception\Util\HttpCode;

class AdminLoginCest 
{
    public function tryLogin(FunctionalTester $I)
    {
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Bonjour, merci de saisir vos identifiants', 'p');
        $I->submitForm('form', ['_username' => 'admin@test.fr', '_password' => 'admin']); 
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Dashboard', 'h2');
    }

    public function tryLoginFail(FunctionalTester $I)
    {
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Bonjour, merci de saisir vos identifiants', 'p');
        $I->submitForm('form', ['_username' => 'admin@test.fr', '_password' => 'mauvais']);
        $I->seeCurrentUrlEquals('/admin/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Invalid credentials', 'p');
    }

    public function tryLoginHelper(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Dashboard', 'h2');
    }
}
