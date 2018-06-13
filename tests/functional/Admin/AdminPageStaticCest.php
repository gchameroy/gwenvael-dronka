<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPageStaticCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin');
        $I->see('SEO', '.nav-label');

        $I->click('SEO');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/seo');
        $I->seeNumberOfElements('#ibox-pages .row-page', FixtureHelper::NB_PAGE_STATIC);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/seo');
        $I->see('Editer', '#ibox-pages tr:nth-child(1) a');

        $I->click('Editer', '#ibox-pages tr:nth-child(1) a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/seo/1/edit');
        $I->submitForm('form', [
            'page_static[titleSEO]' => 'Accueil',
            'page_static[descriptionSEO]' => 'Test description seo acceuil',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/seo');
        $I->see('Test description seo acceuil', 'td');
    }
}
