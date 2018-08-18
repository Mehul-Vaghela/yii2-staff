<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;


?>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu" style="display: none;">
                <li class="nav-header">

                    <div class="dropdown profile-element content-flex">
                        <div style="display: inline-block;">
                            <a href="">
                                <img alt="image" class="img-circle img-profile-small" src="<?=$userModel->getImagePath()?>"/>
                            </a>
                        </div>
                        <div class="padding-left-05" style="overflow: auto">
                            <a href="">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold"><?=$userModel->username?></strong>
                                </span>
                            </span>
                            </a>
                        </div>
                    </div>
                </li>
                <?php
                echo $this->render('@backend/views/layouts/menu');
                ?>
            </ul>
        </div>
    </nav>

<?php

$this->registerJs("

    $('#side-menu').show(350);
    
    ", \yii\web\View::POS_READY);

?>