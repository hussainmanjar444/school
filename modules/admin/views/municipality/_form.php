<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Municipality */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="municipality-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 

     <?php 
        echo $form->field($model, 'province_id')->widget(Select2::class, [
            'data' => ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
            'options' => [
                'placeholder' => 'Select province ...',
                'onchange'=>'
                    $.post( "/admin/common/get-district?id="+$(this).val(), function( data ) {
                      $( "select#district" ).html( data );
                    });',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>  

     <?php 
        if($model->isNewRecord) { $data = []; } 
        else { $data = ArrayHelper::map(\app\models\District::find()->where(['province_id' => $model->province_id])->all(),'id','name'); }
        echo $form->field($model, 'district_id')->widget(Select2::class, [
            'data' => $data,
            'options' => ['placeholder' => 'Select district ...','id' => 'district'],
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
