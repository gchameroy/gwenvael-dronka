<?php

use AppBundle\DataFixtures\Helper\FixtureHelper;
use Codeception\Util\HttpCode;

class WebsiteContactCest
{
    public function tryView(FunctionalTester $I)
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/contact');
        $I->see('Contact', 'h2');
        $I->seeNumberOfElements('.box-zone', FixtureHelper::NB_ZONE);
        $I->seeNumberOfElements('.social li', FixtureHelper::NB_SETTING_SOCIAL_NETWORK * 2);
    }

    public function trySend(FunctionalTester $I)
    {
        $I->amOnPage('/contact');
        $I->submitForm('form', [
            'message[name]' => 'Fluffy Unicorn',
            'message[email]' => 'fluffy@unicorn.com',
            'message[subject]' => 'Unicorns',
            'message[message]' => 'Hello, i love unicorns'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentUrlEquals('/contact?success=1#form');
        $I->canSee('Message envoyé avec succès.', '.successContent');
    }
}
