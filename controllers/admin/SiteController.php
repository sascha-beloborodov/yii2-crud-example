<?php

namespace app\controllers\admin;

use app\common\controllers\auth\AdminAuth;

class SiteController extends AdminAuth
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
