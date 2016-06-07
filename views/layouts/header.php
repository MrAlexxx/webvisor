<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle " data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?= Html::a(
            'Sign out',
            ['/site/logout'],
            ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat pull-right','style'=>['height'=> '48px','padding-top'=>'10px;']]
        ) ?>
    </nav>
</header>
