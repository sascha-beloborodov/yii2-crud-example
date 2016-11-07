<?php
namespace app\components\admin\menu;

use yii\base\Widget;

class SidebarMenu extends Widget
{
    public function run()
    {
        return $this->render('sidebar_menu', [
            'controller' => \Yii::$app->controller->id,
            'action' => \Yii::$app->controller->action->id
        ]);
    }
}
