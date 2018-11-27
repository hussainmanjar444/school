<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\InventoryHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-history-form">

    <?php $form = ActiveForm::begin(); ?>
 

    <?php 
    echo $form->field($model, 'vendor_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookVendor::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Select a vendor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?> 

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?> 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
