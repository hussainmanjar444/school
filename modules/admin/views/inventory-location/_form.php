<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\InventoryLocation */
/* @var $form yii\widgets\ActiveForm */

$getSchool= \app\models\Inventory::find()->select('school_id')->where(['id' => $model->inventory_id])->one(); 
$school_id = $getSchool->school_id;
$data = []; 
if(!$model->isNewRecord) {   
    $data = \yii\helpers\ArrayHelper::map(\app\models\LibraryRoomRack::find()->where(['room_id' => $model->room_id])->all(),'id','name'); 
}
?>

<div class="inventory-location-form">

    <?php $form = ActiveForm::begin(); ?>
 
 
    <?php  
    $dataRoom = \yii\helpers\ArrayHelper::map(\app\models\LibraryRoom::find()->where(['school_id' => $school_id])->all(),'id','name');
    echo $form->field($model, 'room_id')->widget(Select2::class, [
        'data' => $dataRoom,
        'options' => [
            'placeholder' => 'Select a room ...',
            'onchange'=>'
                    $.post( "/admin/common/get-library-room-rack?id="+$(this).val(), function( data ) {
                      $( "select#rack" ).html( data );
                    });',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 
 
    <?php  
    echo $form->field($model, 'rack_id')->widget(Select2::class, [
        'data' => $data,
        'options' => ['placeholder' => 'Select a rack ...','id' => 'rack'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 
    <?php  
    echo $form->field($model, 'shelf_id')->widget(Select2::class, [
        'data' => \app\helpers\Configuration::GET_SHELF_ARRAY,
        'options' => ['placeholder' => 'Select a shelf ...'],
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
