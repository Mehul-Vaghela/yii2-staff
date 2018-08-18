<?php

/* @var $this \yii\web\View */
/* @var $content string */

/*

Note: For some documentations regarding layouts, please refer to main.php.

*/

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        body{
            background-color: #ffffff !important;
        }
    </style>
</head>
<body>
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <?=$content?>
    </div>
    <?php
    #echo $this->render('@backend/views/layouts/modal');
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>