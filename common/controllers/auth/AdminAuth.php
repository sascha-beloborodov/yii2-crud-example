<?php

namespace app\common\controllers\auth;

use app\models\User;
use Yii;

class AdminAuth extends GlobalAuth
{

    public $layout = '/admin/main';
    /**
     * Checking access
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        if ($this->isAdmin()) {
            return parent::beforeAction($action);
        } else {
            Yii::$app->user->logout(true);
        }
    }

    /**
     * Checking is admin
     *
     * @return bool
     */
    private function isAdmin()
    {
        if (Yii::$app->user->isGuest || User::ADMIN_ROLE != Yii::$app->user->identity->role) {
            return false;
        }
        return true;
    }

}