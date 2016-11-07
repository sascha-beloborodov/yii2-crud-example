<?php

/* @var $this \yii\web\View */

use app\components\admin\menu\SidebarMenu;
use app\assets\AdminAsset;
use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
AdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
    <header class="main-header">
        <a href="<?php echo Yii::$app->homeUrl; ?>" class="logo">
            <span class="logo-mini"><b>+</b></span>
            <span class="logo-lg"><b>Users-Services list</b></span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">

            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><?= Html::a('Log Out', '/site/logout', [
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Are you sure?'
                            ]
                        ]); ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">


        <section class="sidebar">
            <?= SidebarMenu::widget(); ?>
        </section>

    </aside>
    <div class="wrapper">
        <?= $this->render(
            'content.php', ['content' => $content]
        ) ?>
    </div>

    <div class="control-sidebar-bg"></div>
</div>

<div class="footer" style="height: 100px;background-color: #ecf0f5;">

</div>


<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
