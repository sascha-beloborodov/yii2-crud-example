<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsersSites */

$this->title = 'Create Users Sites';
$this->params['breadcrumbs'][] = ['label' => 'Users Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-sites-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
