<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?> 

    <?php 
    echo $form->field($model, 'province_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Select province ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
