<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor; 
?>

<div class="book-author-form">
    <b>Fine per day : NRP <?= $finePerDay; ?></b><hr>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'actual_fine')->textInput(['maxlength' => true, 'value' => $actualFine, 'disabled' => true]) ?>

    <?= $form->field($model, 'collected_fine')->textInput(['maxlength' => true]) ?> 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Receive'), ['class' => 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
