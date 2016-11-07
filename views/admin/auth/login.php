<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Admin Sign In';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12 text-center">
            <div class="panel panel-default">
                <h1>Admin Sign In</h1>
                <div class="panel-body">
                    <div class="form-group">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($model, 'username') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <div class="form-group">
                            <?= Html::submitButton('Sign In',
                                ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>