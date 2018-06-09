<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPageBlockImageCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->seeNumberOfElements('.item-image', FixtureHelper::NB_PAGE_BLOCK * FixtureHelper::NB_PAGE_BLOCK_IMAGE);
    }

    public function tryListManager(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->see('Gestionaire d\'images', 'a');

        $I->click('Gestionaire d\'images', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/blocks/1/images/manager');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PAGE_BLOCK_IMAGE);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/blocks/1/images/manager');
        $I->see('Ajouter une image', 'a');

        $I->click('Ajouter une image', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/blocks/1/images/add');

        $I->attachFile('page_block_image[path]', 'img.png');
        $I->submitForm('form', []);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/blocks/1/images/manager');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PAGE_BLOCK_IMAGE  + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/blocks/1/images/manager');
        $I->see('Editer', 'a');

        $I->click('Editer', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/images/1/edit');

        $I->attachFile('page_block_image[path]', 'img.png');
        $I->submitForm('form', []);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/blocks/1/images/manager');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/blocks/1/images/manager');
        $I->see('Supprimer', 'button');

        $I->click('Supprimer', 'button');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/blocks/1/images/manager');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PAGE_BLOCK_IMAGE  - 1);
    }
}
