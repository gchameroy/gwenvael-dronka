<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPriceImageCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices');
        $I->see(sprintf('Images (%s)', FixtureHelper::NB_PRICE_IMAGE), 'a');

        $I->click(sprintf('Images (%s)', FixtureHelper::NB_PRICE_IMAGE), 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/1/images');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PRICE_IMAGE);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices/1/images');
        $I->see('Ajouter une image', 'a');

        $I->click('Ajouter une image', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/1/images/add');

        $I->attachFile('price_image[path]', 'img.png');
        $I->submitForm('form', []);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/1/images');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PRICE_IMAGE  + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices/1/images');
        $I->see('Editer', 'a');

        $I->click('Editer', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/images/1/edit');

        $I->attachFile('price_image[path]', 'img.png');
        $I->submitForm('form', []);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/1/images');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/prices/1/images');
        $I->see('Supprimer', 'button');

        $I->click('Supprimer', 'button');

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/prices/1/images');
        $I->seeNumberOfElements('#ibox-images .row-image', FixtureHelper::NB_PRICE_IMAGE  - 1);
    }
}
