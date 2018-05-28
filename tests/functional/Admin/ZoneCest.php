<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class ZoneCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Sites', '.nav-label');

        $I->click('Sites');
        $I->seeCurrentUrlEquals('/admin/zones');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-zones .row-zone', FixtureHelper::NB_ZONE);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/zones');
        $I->see('Ajouter un site', 'a');

        $I->click('Ajouter un site', 'a');
        $I->seeCurrentUrlEquals('/admin/zones/add');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'zone[address][title]' => 'Test add zone',
            'zone[address][city]' => 'Chaumont',
            'zone[address][zipCode]' => '52000',
            'zone[address][country]' => 'France',
        ]);

        $I->seeCurrentUrlEquals('/admin/zones');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test add zone', 'td');
        $I->seeNumberOfElements('#ibox-zones .row-zone', FixtureHelper::NB_ZONE + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/zones');
        $I->see('Editer', '#ibox-zones tr:nth-child(1) a');

        $I->click('Editer', '#ibox-zones tr:nth-child(1) a');
        $I->seeCurrentUrlEquals('/admin/zones/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'zone[address][title]' => 'Test edit zone',
            'zone[address][city]' => 'Chaumont',
            'zone[address][zipCode]' => '52000',
            'zone[address][country]' => 'France',
        ]);

        $I->seeCurrentUrlEquals('/admin/zones');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test edit zone', 'td');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/zones');
        $I->see('Supprimer', '#ibox-zones tr:nth-child(1) button');

        $I->click('Supprimer', '#ibox-zones tr:nth-child(1) button');
        $I->seeCurrentUrlEquals('/admin/zones');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('#ibox-zones .row-zone', FixtureHelper::NB_ZONE - 1);
    }
}
