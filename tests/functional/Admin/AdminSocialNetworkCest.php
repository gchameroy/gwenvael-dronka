<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminSocialNetworkCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('Réseaux sociaux', '.nav-label');

        $I->click('Réseaux sociaux');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/social-networks');
        $I->seeNumberOfElements('#ibox-social-networks .row-social-network', FixtureHelper::NB_SETTING_SOCIAL_NETWORK);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/social-networks');
        $I->see('Ajouter un réseau social', 'a');

        $I->click('Ajouter un réseau social', 'a');
        $I->seeCurrentUrlEquals('/admin/social-networks/add');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'setting_social_network[url]' => 'http://facebook.com/add-unicorns',
            'setting_social_network[socialNetwork]' => '1',
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/social-networks');
        $I->see('http://facebook.com/add-unicorns', 'td');
        $I->seeNumberOfElements('#ibox-social-networks .row-social-network', FixtureHelper::NB_SETTING_SOCIAL_NETWORK + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/social-networks');
        $I->see('Editer', 'a');

        $I->click('Editer', 'a');
        $I->seeCurrentUrlEquals('/admin/social-networks/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'setting_social_network[url]' => 'http://facebook.com/edit-unicorns',
            'setting_social_network[socialNetwork]' => '1',
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/social-networks');
        $I->see('http://facebook.com/edit-unicorns', 'td');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/social-networks');
        $I->see('Supprimer', 'button');

        $I->click('Supprimer', 'button');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/social-networks');
        $I->seeNumberOfElements('#ibox-social-networks .row-social-network', FixtureHelper::NB_SETTING_SOCIAL_NETWORK - 1);
    }
}
