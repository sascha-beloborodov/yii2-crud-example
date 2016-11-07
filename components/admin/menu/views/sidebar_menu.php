<?php
use yii\helpers\Url;
?>

<ul class="sidebar-menu">
    <li class="header">Menu</li>

    <li <?= (strstr($controller, 'admin/site') !== false ? 'class="active"' : '') ?>>
        <a href="<?= Yii::$app->homeUrl . '/admin'; ?>"><i class="fa fa-tachometer"></i>
            <span>Main</span>
        </a>
    </li>

    <li <?= ($action === 'list' ? 'class="active"' : '') ?>>
        <a href="<?= Url::to(['/admin/services/list']); ?>">
            <i class="fa fa-exclamation-triangle"></i>
            <span>
                List of Users/Services
            </span>
        </a>
    </li>

    <li <?= (strstr($controller, 'admin/services') !== false && $action !== 'list' ? 'class="active"' : '') ?>>
        <a href="<?= Url::to(['/admin/services/']); ?>">
            <i class="fa fa-exclamation-triangle"></i>
            <span>
                Services
            </span>
        </a>
    </li>

    <li <?= (strstr($controller, 'admin/users') !== false && $action !== 'list' ? 'class="active"' : '') ?>>
        <a href="<?= Url::to(['/admin/users/']); ?>">
            <i class="fa fa-exclamation-triangle"></i>
            <span>
                Users
            </span>
        </a>
    </li>

    <li <?= (strstr($controller, 'admin/users-sites') !== false && $action !== 'list' ? 'class="active"' : '') ?>>
        <a href="<?= Url::to(['/admin/users-sites/']); ?>">
            <i class="fa fa-exclamation-triangle"></i>
            <span>
                Users Sites
            </span>
        </a>
    </li>
</ul>
