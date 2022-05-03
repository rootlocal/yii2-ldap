<?php

namespace tests\codeception\unit;

use tests\codeception\fixtures\AdminFixture;

/**
 * Class TestCase
 * @package tests\codeception\unit
 */
class TestCase extends \yii\codeception\TestCase
{
    public $appConfig = '@tests/codeception/config/unit.php';

    protected function setUp()
    {
        parent::setUp();
        //$this->loadFixtures();
    }

   /* public function fixtures()
    {
        return [
            AdminFixture::className(),
        ];
    }*/

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    /*protected function destroy_application()
    {
        \Yii::$app = null;
    }*/
}
