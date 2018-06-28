<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPageCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('Pages', '.nav-label');

        $I->click('Pages');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeNumberOfElements('#ibox-pages .row-page', FixtureHelper::NB_PAGE);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages');
        $I->see('Ajouter une page', 'a');

        $I->click('Ajouter une page', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/add');
        $I->submitForm('form', [
            'page[title]' => 'Test ajout page',
            'page[titleSeo]' => 'Test titre seo ajout de page',
            'page[descriptionSeo]' => 'Test description seo ajout de page',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Test ajout page', 'h2');

        $I->amOnPage('/admin/pages');
        $I->see('Test ajout page', 'a');
        $I->seeNumberOfElements('#ibox-pages .row-page', FixtureHelper::NB_PAGE + 1);
    }

    public function tryView(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Troubles', 'h2');
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1/edit');
        $I->seeCurrentUrlEquals('/admin/pages/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'page[title]' => 'Test edit page',
            'page[titleSeo]' => 'Test titre seo edit page',
            'page[descriptionSeo]' => 'Test description seo edit page',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->see('Test edit page', 'h2');
        $I->amOnPage('/admin/pages');
        $I->see('Test edit page', 'a');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages');
        $I->see('Supprimer', 'button');
        $I->seeNumberOfElements('#ibox-pages .row-page', FixtureHelper::NB_PAGE);

        $I->click('Supprimer', 'button');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeNumberOfElements('#ibox-pages .row-page', FixtureHelper::NB_PAGE - 1);
    }
}
