<?php 
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

?>
<div class="box">
    <div class="box-header">
        <h3>School logo</h3>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <?php  echo $form->field($model, 'uploads')->widget(FileInput::class, [
            'options' => ['multiple' => false, 'accept' => 'image/*','id'=>uniqid()],
            'pluginOptions' => [
                'uploadUrl' => Url::toRoute(['/admin/media/upload?identity='.$model1->getAvatarIdentity()."&type=".$model::AVATAR]),
                'initialPreview'=>($model1->hasAvatar())? $model1->getAvatar(true)['url']:[],
                'initialPreviewAsData'=>true,
                'initialCaption'=>"Upload school logo",
                'initialPreviewConfig' => ($model1->hasAvatar())?$model1->getAvatar(true)['config']:[],
                'overwriteInitial'=>true,
                'maxFileSize'=>0,
                'showRemove' => true,
                'showUpload' => false,
               // 'showBrowse' => ($model1->hasAvatar())?false:true,

            ]

        ])->label(false);
        ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
