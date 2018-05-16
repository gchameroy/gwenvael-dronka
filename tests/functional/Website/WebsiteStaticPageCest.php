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
}
