<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class MenuCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Menus', '.nav-label');

        $I->click('Menus');
        $I->seeCurrentUrlEquals('/admin/menus');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-menus .row-menu', FixtureHelper::NB_MENU);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/menus');
        $I->see('Ajouter un menu', 'a');

        $I->click('Ajouter un menu', 'a');
        $I->seeCurrentUrlEquals('/admin/menus/add');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'menu[title]' => 'Test add menu',
            'menu[routeName]' => 'website_home',
            'menu[routeSlug]' => '',
        ]);

        $I->seeCurrentUrlEquals('/admin/menus');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test add menu', 'td');
        $I->seeNumberOfElements('#ibox-menus .row-menu', FixtureHelper::NB_MENU + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/menus');
        $I->see('Editer', '#ibox-menus tr:nth-child(1) a');

        $I->click('Editer', '#ibox-menus tr:nth-child(1) a');
        $I->seeCurrentUrlEquals('/admin/menus/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'menu[title]' => 'Test edit menu',
            'menu[routeName]' => 'website_home',
            'menu[routeSlug]' => '',
        ]);

        $I->seeCurrentUrlEquals('/admin/menus');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test edit menu', 'td');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/menus');
        $I->see('Supprimer', '#ibox-menus tr:nth-child(1) button');

        $I->click('Supprimer', '#ibox-menus tr:nth-child(1) button');
        $I->seeCurrentUrlEquals('/admin/menus');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-menus .row-menu', FixtureHelper::NB_MENU - 1);
    }
}
