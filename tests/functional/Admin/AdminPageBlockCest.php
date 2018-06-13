<?php

use Codeception\Util\HttpCode;
use AppBundle\DataFixtures\Helper\FixtureHelper;

class AdminPageBlockCest
{
    public function tryList(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->seeNumberOfElements('.ibox-block', FixtureHelper::NB_PAGE_BLOCK);
    }

    public function tryAdd(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->see('Ajouter un block', 'a');

        $I->click('Ajouter un block', 'a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/1/blocks/add');

        $I->submitForm('form', [
            'page_block[title]' => 'Test add block',
            'page_block[content]' => 'Lorem ipsum',
            'page_block[action]' => 1,
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->see('Test add block', 'h2');
        $I->seeNumberOfElements('.ibox-block', FixtureHelper::NB_PAGE_BLOCK  + 1);
    }

    public function tryEdit(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->see('', '#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div:nth-child(2) > div > div > div.ibox-title > div > a');

        $I->click('', '#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div:nth-child(2) > div > div > div.ibox-title > div > a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/blocks/1/edit');

        $I->submitForm('form', [
            'page_block[title]' => 'Test edit block',
            'page_block[content]' => 'Lorem ipsum',
            'page_block[action]' => 1,
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->see('Test edit block', 'h2');
    }

    public function tryDelete(FunctionalTester $I)
    {
        $I->amLoggedAsAdmin();
        $I->amOnPage('/admin/pages/1');
        $I->see('', '#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div:nth-child(2) > div > div > div.ibox-title > div > form > button');

        $I->click('', '#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div:nth-child(2) > div > div > div.ibox-title > div > form > button');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/admin/pages/1');
        $I->seeNumberOfElements('.ibox-block', FixtureHelper::NB_PAGE_BLOCK - 1);
    }
}
