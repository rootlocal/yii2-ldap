<?php

use \FunctionalTester;
use yii\log\Logger;

class HomePageScenarioCest
{

    public function _before(FunctionalTester $I)
    {

    }

    public function tryToTest(FunctionalTester $I)
    {
    }

    public function checkHomeUrl(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('My Company');
    }

}
