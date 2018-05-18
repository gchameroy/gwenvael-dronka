<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPageCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages');
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Pages', 'h2');
        $I->seeNumberOfElements('.ibox-content tr', FixtureHelper::NB_PAGE);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/add');
        $I->seeCurrentUrlEquals('/admin/pages/add');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'page[title]' => 'Test ajout page',
            'page[description]' => 'Test description ajout de page',
            'page[titleSeo]' => 'Test titre seo ajout de page',
            'page[descriptionSeo]' => 'Test description seo ajout de page',
        ]);
        $I->see('Test ajout page', 'h2');
        $I->amOnPage('/admin/pages');
        $I->see('Test ajout page', 'a');
        $I->seeNumberOfElements('.ibox-content tr', FixtureHelper::NB_PAGE + 1);
    }

    public function tryView(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Page N°1', 'h2');
    }

    public function tryUnpublishPublish(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages');
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeNumberOfElements('.ibox-content .label.label-default', 0);
        $I->dontSeeInRepository(\AppBundle\Entity\Page::class, [
            'id' => 1,
            'publishedAt' => null
        ]);
        $I->submitForm('tr:first-child form:nth-child(1)', []);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeInRepository(\AppBundle\Entity\Page::class, [
            'id' => 1,
            'publishedAt' => null
        ]);

        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeNumberOfElements('.ibox-content .label.label-default', 1);
        $I->seeNumberOfElements('.ibox-content .label.label-info', FixtureHelper::NB_PAGE - 1);
        $I->submitForm('tr:first-child form:nth-child(1)', []);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->dontSeeInRepository(\AppBundle\Entity\Page::class, [
            'id' => 1,
            'publishedAt' => null
        ]);
        $I->seeNumberOfElements('.ibox-content .label.label-info', FixtureHelper::NB_PAGE);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1/edit');
        $I->seeCurrentUrlEquals('/admin/pages/1/edit');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->submitForm('form', [
            'page[title]' => 'Test edit page',
            'page[description]' => 'Test description edit page',
            'page[titleSeo]' => 'Test titre seo edit page',
            'page[descriptionSeo]' => 'Test description seo edit page',
        ]);
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->see('Test edit page', 'h2');
        $I->amOnPage('/admin/pages');
        $I->see('Test edit page', 'a');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages');
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeNumberOfElements('.ibox-content tr', FixtureHelper::NB_PAGE);
        $I->submitForm('tr:first-child form:nth-child(3)', []);
        $I->seeCurrentUrlEquals('/admin/pages');
        $I->seeNumberOfElements('.ibox-content tr', FixtureHelper::NB_PAGE - 1);
    }
}
