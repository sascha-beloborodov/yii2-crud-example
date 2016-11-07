<?php

namespace app\common\controllers\auth;

use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class GuestAuth extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => 'error.twig',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }
}
