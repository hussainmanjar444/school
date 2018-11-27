<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
use dektrium\user\helpers\Timezone;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */
$this->title ="My profile";
?>
<div class="row">

    <div class="col-sm-12 col-md-8">
	<div class="box">
		<div class="box-header with-border">
              <h3 class="box-title">My profile</h3>
        </div>

    	<div class="box-body">

            <?php $form = ActiveForm::begin(); ?> 
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 

                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'gender')->radioList( ['male'=>'Male', 'female' => 'Female'] ) ?>    
                    <?= $form->field($model, 'mobile')->textInput() ?> 
                    <?= $form->field($model, 'blood_group')->textInput() ?>
                    <?= $form->field($model, 'website')->textInput() ?>
                    <?= $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        ArrayHelper::map(
                            Timezone::getAll(),
                            'timezone',
                            'name'
                        )
                    ); ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 


                   
                    <?= $form->field($model, 'address_p')->textArea(['id' => 'addressP']) ?>   


                    <?php 
                        echo $form->field($model, 'province_p')->widget(Select2::class, [
                            'data' => ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                            'options' => [
                                'placeholder' => 'Select province ...',
                                'id' => 'provinceP',
                                'onchange'=>'
                                    $.post( "/admin/common/get-district?id="+$(this).val(), function( data ) {
                                      $( "select#districtP" ).html( data );
                                    });',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>  

                     <?php 
                        if($model->isNewRecord) { $data = []; } 
                        else { $data = ArrayHelper::map(\app\models\District::find()->where(['province_id' => $model->province_p])->all(),'id','name'); }
                        echo $form->field($model, 'district_p')->widget(Select2::class, [
                            'data' => $data,
                            'options' => [
                                'placeholder' => 'Select district ...',
                                'id' => 'districtP',
                                'onchange'=>'
                                    $.post( "/admin/common/get-municipality?id="+$(this).val(), function( data ) {
                                      $( "select#municipalityP" ).html( data );
                                    });',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?> 
                     <?php 
                        if($model->isNewRecord) { $data = []; } 
                        else { $data = ArrayHelper::map(\app\models\Municipality::find()->where(['district_id' => $model->district_p])->all(),'id','name'); }
                        echo $form->field($model, 'municipality_p')->widget(Select2::class, [
                            'data' => $data,
                            'options' => [
                                'placeholder' => 'Select municipality ...',
                                'id' => 'municipalityP',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?> 

                    <?= $form->field($model, 'ward_p')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_WARDS_ARRAY,
                        'options' => ['placeholder' => 'Select ward ...','id' => 'wardP'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>

                    <?php /*$form->field($model, 'addressCheck')->checkbox(['onclick' => 'if( this.checked ) { fillForm2(); } else { clearForm2(); }']);*/ ?>
                    <input type="checkbox" id="filladdress" name="filladdress"/> <b>Use same as temporary address</b>
 
                </div>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 
                    <?= $form->field($model, 'address_t')->textArea(['id' => 'addressT']) ?>

                    <?php 
                        echo $form->field($model, 'province_t')->widget(Select2::class, [
                            'data' => ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                            'options' => [
                                'placeholder' => 'Select province ...',
                                'id' => 'provinceT',
                                'onchange'=>'
                                    $.post( "/admin/common/get-district?id="+$(this).val(), function( data ) {
                                      $( "select#districtT" ).html( data );
                                    });',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>  

                     <?php  
                        echo $form->field($model, 'district_t')->widget(Select2::class, [
                            'data' => ArrayHelper::map(\app\models\District::find()->all(),'id','name'),
                            'options' => [
                                'placeholder' => 'Select district ...',
                                'id' => 'districtT',
                                'onchange'=>'
                                    $.post( "/admin/common/get-municipality?id="+$(this).val(), function( data ) {
                                      $( "select#municipalityT" ).html( data );
                                    });',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?> 
                   
                     <?php  
                        echo $form->field($model, 'municipality_t')->widget(Select2::class, [
                            'data' => ArrayHelper::map(\app\models\Municipality::find()->all(),'id','name'),
                            'options' => [
                                'placeholder' => 'Select municipality ...',
                                'id' => 'municipalityT',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>  
                    <?= $form->field($model, 'ward_t')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_WARDS_ARRAY,
                        'options' => ['placeholder' => 'Select ward ...','id' => 'wardT'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>
 

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                    </div>

                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
    <div class="col-sm-12 col-md-4">
    	<?=  $this->render('_avatarUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?> 
    </div>
</div> 

<?php
/* start getting the num */
$script = <<< JS
$(function(){
    $('#emailSelection').change(function(){ 
      var emailSelection = $(this).val();
      if(emailSelection=="enter_email")
      {
         $("#emailField").show();
      }
      else
      {
        $("#emailField").hide();
      }
    });

});

$(document).ready(function(){
    var globalTimeout;
    $("#filladdress").on("click", function(){
         if (this.checked) { 
                $("#addressT").val($("#addressP").val());                        
                $('#provinceT').val($("#provinceP").val()).trigger('change'); 
                $('#districtT').val($("#districtP").val()).trigger('change'); 
                $('#municipalityT').val($("#municipalityP").val()).trigger('change'); 
                $('#wardT').val($("#wardP").val()).trigger('change'); 

    }
    else {
        $("#addressT").val('');           
        $("#provinceT").val('').trigger('change');           
        $("#districtT").val('').trigger('change');           
        $("#municipalityT").val('').trigger('change');           
        $("#wardT").val('').trigger('change');           
    }
    }); 
});
 


JS;
$this->registerJs($script);
/* end getting the num */
?> 
