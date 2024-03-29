<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

}
