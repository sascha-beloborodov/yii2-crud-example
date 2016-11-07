<?php

namespace app\controllers\admin;

use app\common\controllers\auth\AdminAuth;
use app\common\controllers\auth\GuestAuth;
use app\models\LoginForm;
use Yii;

class AuthController extends GuestAuth
{
    public $layout = '/admin/auth';

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        $model->setScenario(LoginForm::SCENARIO_ADMIN);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['admin/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}

