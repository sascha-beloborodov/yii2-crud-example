<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/adminlte/AdminLTE.min.css',
        'css/adminlte/skin-blue.min.css',
        'css/admin.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js',
        'https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js',
        'js/adminlte/app.min.js',
        'js/services.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}