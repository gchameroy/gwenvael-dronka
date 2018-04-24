<?php

use Codeception\Util\HttpCode;

class DefaultCest
{
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Welcome to Symfony', '#container h1');
    }
}
