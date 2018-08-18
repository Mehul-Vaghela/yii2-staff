<?php

use yii\db\Query;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Update Image';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Update Image</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                            <input type="hidden" id="croppie_default_img" value="<?=$model->getImagePath()?>"/> <?php # only serves as storage of the path of the current set profile image, this is related to the view only and is not directly related to the model ?>
                            <div id="croppie_current_img_container" style="display: none;">
                                <img src="<?=$model->getImagePath()?>" id="croppie_current_img" class="img-avatar-lg"/>
                            </div>
                            <div id="croppie_upload_container" style="display: none;">

                            </div>
                            <div id="croppie_control_buttons_container" style="display: none;">
                                <button type="button" id="croppie_upload_file_set">Set</button> 
                                <button type="button" id="croppie_upload_file_cancel">Cancel</button>
                            </div>

                            <p>&nbsp;</p>

                            <?php

                            if($model->hasImage()){
                            # show option to remove image if the user has an image
                            ?>
                            <div id="croppie_current_img_remove_container" style="display: none;">
                                <?= $form->field($model, 'remove_img')->checkbox(array('label'=>'Remove Image')); ?>
                            </div>
                            <?php
                            }
                            ?>

                            <p>&nbsp;</p>

                            <?php

                            $this->registerJs("

                                croppiePhase1();

                                ");

                            ?>
                            
                            <div class="row">
                                <div class="col-xs-12 text-left">
                                    <?= $form->field($model, 'img_upload')->fileInput(['id' => 'croppie_upload_file', 'data-height' => 160, 'data-width' => 160]) ?>
                                    <?= $form->field($model, 'img_upload_base64')->hiddenInput(['id' => 'img_upload_base64'])->label(false)?>
                                    <?= $form->field($model, 'img')->hiddenInput()->label(false)?>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
