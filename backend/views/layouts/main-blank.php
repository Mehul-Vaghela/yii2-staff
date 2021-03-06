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
use yii\helpers\Url;
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
        <meta name="google-site-verification" content="Y9VPCuJCKWiRCQWH7qncJBcUcoMd-2PzzIoYmB4-4R4" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <?php

    if(Yii::$app->user->identity){
//if the user is logged in

        $userModel = \backend\models\User::findOne(['id' => Yii::$app->user->identity->id]);

        ?>
        <body>
        <?php $this->beginBody() ?>
        <div id="wrapper">
            <?php echo $this->render('header', ['userModel' => $userModel])?>
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">

                            <li>
                                <?=Html::a('Log Out</li>', ['/site/logout'], [
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ])?>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg">
                    <div class="col-lg-10">
                        <!-- <h2><?=$this->title?></h2> -->
                        <br/>
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                        <br/>
                        <?= Alert::widget() ?>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <?=$content?>
            </div>
        </div>
        <?php
        echo $this->render('@backend/views/layouts/modal');
        ?>
        <?php $this->endBody() ?>
        </body>
        <?php
    }
    else{
//else if the user is NOT logged in
        ?>

        <body class="gray-bg">
        <div id="wrapper">
            <?php $this->beginBody() ?>
            <?=$content?>
            <?php
            echo $this->render('@backend/views/layouts/modal');
            ?>
            <?php $this->endBody() ?>
        </div>
        </body>

        <?php
    }

    ?>

    </html>
<?php $this->endPage() ?>