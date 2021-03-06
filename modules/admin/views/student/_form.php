<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">

    <div class="box-body">
        <div class="row">

            <?php $form = ActiveForm::begin(); ?> 
            <div class="col-sm-12 col-md-4">

                <div class="student-form">
 
                    <?php

                    echo $form->field($model, 'school_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\School::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a school ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('School  '.Html::a('Add New School',''));
                    ?> 
                    <?= $form->field($model, 'class_id')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_CLASS_ARRAY,
                        'options' => ['placeholder' => 'Select a class ...'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>
                    <?= $form->field($model, 'section')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_SECTION_ARRAY,
                        'options' => ['placeholder' => 'Select a section ...'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>

                    <?= $form->field($model, 'rollno')->textInput() ?>

                    <?= $form->field($model, 'regno')->textInput() ?> 

                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'gender')->radioList( ['male'=>'Male', 'female' => 'Female'] ) ?> 

<?php if($model->isNewRecord){ ?>
                    <?php $model->email_selection = 'create_random'; ?>
                    <?php /*$form->field($model, 'email_selection')->radioList( ['create_random'=>'Create Random', 'enter_email' => 'Enter Email'],['onclick' => "js:emailSelection(this)" ] )*/ ?> 
                    <?= $form->field($model, 'email_selection')->widget(Select2::classname(), [
                        'data' => ['create_random'=>'Create Random', 'enter_email' => 'Enter Email'],
                        'language' => 'en',
                        'options' => [
                            'placeholder' => 'Select selection ','id' => 'emailSelection'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]); ?> 

                    <div id="emailField" style="display:none"> 
                        <?= $form->field($model, 'email')->textInput() ?>
                    </div>  
                    <?= $form->field($model, 'password')->passwordInput() ?> 
                    
<?php } ?>    
 

 
                    <?= $form->field($model, 'mobile')->textInput() ?> 

                </div>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 


                    <?= $form->field($model, 'blood_group')->textInput() ?>
                   
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
                    <input type="checkbox" id="filladdress" name="filladdress"/> <b>Use same as temporary address<b>
 
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

                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::STATUS_ARRAY, 
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
<script type="text/javascript">
// function fillForm2() {
//     document.getElementById( 'addressT' ).value = document.getElementById( 'addressP' ).value;
//     document.getElementById( 'wardT' ).value = document.getElementById( 'wardP' ).value;
//     // document.getElementById( 'districtT' ).value = document.getElementById( 'districtP' ).value;
//     // document.getElementById( 'municipalityT' ).value = document.getElementById( 'municipalityP' ).value;
//     // document.getElementById( 'wardT' ).value = document.getElementById( 'wardP' ).value;
// }
// function clearForm2() {
//     alert("clear form");
// }
</script>
