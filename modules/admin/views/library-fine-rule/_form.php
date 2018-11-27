<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryFineRule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="library-fine-rule-form">

    <?php $form = ActiveForm::begin(); ?> 
     <?php

    echo $form->field($model, 'school_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\School::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Select a school ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 

    <?= $form->field($model, 'name')->textInput() ?> 

    <?= $form->field($model, 'amount')->textInput() ?> 

    <?= $form->field($model, 'details')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?> 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
