<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPriceCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Tarifs', '.nav-label');

        $I->click('Tarifs');
        $I->seeCurrentUrlEquals('/admin/prices');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-prices .row-price', FixtureHelper::NB_PRICE + FixtureHelper::NB_OFFER);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices');
        $I->see('Ajouter un tarif', 'a');

        $I->click('Ajouter un tarif', 'a');
        $I->seeCurrentUrlEquals('/admin/prices/add');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'price[title]' => 'Test add price',
            'price[price]' => 500,
            'price[label]' => '2 hours',
            'price[description]' => 'I love unicorns',
            'price[content]' => '<p>I love unicorns</p>',
            'price[offer]' => false,
        ]);

        $I->seeCurrentUrlEquals('/admin/prices');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test add price', 'td');
        $I->seeNumberOfElements('#ibox-prices .row-price', FixtureHelper::NB_PRICE + FixtureHelper::NB_OFFER + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices');
        $I->see('Editer', '#ibox-prices tr:nth-child(1) a');

        $I->click('Editer', '#ibox-prices tr:nth-child(1) a');
        $I->seeCurrentUrlEquals('/admin/prices/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'price[title]' => 'Test edit price',
            'price[price]' => 500,
            'price[label]' => '2 hours',
            'price[description]' => 'I love unicorns',
            'price[content]' => '<p>I love unicorns</p>',
            'price[offer]' => true,
        ]);

        $I->seeCurrentUrlEquals('/admin/prices');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test edit price', 'td');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices');
        $I->see('Supprimer', '#ibox-prices tr:nth-child(1) button');

        $I->click('Supprimer', '#ibox-prices tr:nth-child(1) button');
        $I->seeCurrentUrlEquals('/admin/prices');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-prices .row-price', FixtureHelper::NB_PRICE + FixtureHelper::NB_OFFER - 1);
    }
}
