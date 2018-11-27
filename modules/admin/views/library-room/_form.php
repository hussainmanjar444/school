<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryRoom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="library-room-form">

    <?php $form = ActiveForm::begin(); ?> 
    
    <?php

    echo $form->field($model, 'school_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\School::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Select a school ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('School  '.Html::a('Add New School',''));
    ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?> 
    <?php

    echo $form->field($model, 'floor')->widget(Select2::class, [
        'data' => \app\helpers\Configuration::GET_FLOOR_ARRAY,
        'options' => ['placeholder' => 'Select a floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
