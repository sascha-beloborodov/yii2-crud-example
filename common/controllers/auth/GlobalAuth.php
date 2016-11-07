<?php

namespace app\common\controllers\auth;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class GlobalAuth
 */
class GlobalAuth extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    [
                        'actions' => null,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),

            ],
        ];
    }

    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('/login/');
        } else {
            return true;
        }
    }
}
