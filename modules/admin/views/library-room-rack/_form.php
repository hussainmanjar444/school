<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryRoomRack */
/* @var $form yii\widgets\ActiveForm */

if($model->isNewRecord) { 
    $data = []; 
    $model->school_id = $model->school_id;
} else { 
    $model->school_id = $model->room->school_id;
    $data = \yii\helpers\ArrayHelper::map(\app\models\LibraryRoom::find()->where(['school_id' => $model->school_id])->all(),'id','name'); 
}
?>

<div class="library-room-rack-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    echo $form->field($model, 'school_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\School::find()->all(),'id','name'),
        'options' => [
            'placeholder' => 'Select a school ...',
            'onchange'=>'
                    $.post( "/admin/common/get-library-room?id="+$(this).val(), function( data ) {
                      $( "select#room" ).html( data );
                    });',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('School  '.Html::a('Add New School',''));
    ?> 
    <?php  
    echo $form->field($model, 'room_id')->widget(Select2::class, [
        'data' => $data,
        'options' => ['placeholder' => 'Select a room ...','id' => 'room'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Room  '.Html::a('Add New Room',''));
    ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
 

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
