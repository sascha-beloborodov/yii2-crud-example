<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSiteForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-sites-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">User info</h3>
                </div>
                <div class="panel-body">
                    <div>
                        Username:&nbsp;
                        <span id="user-username"><?= $model->user->username ?? '' ?></span>
                    </div>
                    <div>
                        First Name:&nbsp;
                        <span id="user-first_name"><?= $model->user->first_name ?? '' ?></span>
                    </div>
                    <div>
                        Last Name:&nbsp;
                        <span id="user-last_name"><?= $model->user->last_name ?? '' ?></span>
                    </div>
                    <div>
                        Email:&nbsp;
                        <span id="user-email"><?= $model->user->email ?? '' ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="search-user-input">Type in username:</label>
                <input type="text" id="search-user-input" class="form-control">
            </div>
            <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>
        </div>

        <div class="col-md-6 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Service info</h3>
                </div>
                <div class="panel-body">
                    <div>
                        Type of Service:&nbsp;
                        <span id="service-type"><?= $model->service->type ?? '' ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="search-service-input">Type in Service:</label>
                <input type="text" id="search-service-input" class="form-control">
            </div>
            <?= $form->field($model, 'service_id')->hiddenInput()->label('') ?>
        </div>

    </div>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord() ? 'Create' : 'Update', ['class' => $model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.2.26/jquery.autocomplete.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/user-site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>