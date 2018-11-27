<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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

                    echo $form->field($model, 'student_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\School::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a school ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('School  '.Html::a('Add New School',''));
                    ?>

                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'gender')->radioList( ['male'=>'Male', 'female' => 'Female'] ) ?> 

<?php if($model->isNewRecord){ ?>
                    <?php $model->email_selection = 'create_random'; ?>
                    <?php /*$form->field($model, 'email_selection')->radioList( ['create_random'=>'Create Random', 'enter_email' => 'Enter Email'],['onclick' => "js:emailSelection(this)" ] )*/ ?> 
                    <?= $form->field($model, 'email_selection')->widget(Select2::classname(), [
                        'data' => ['create_random'=>'Create Random', 'enter_email' => 'Enter Email'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select selection ','id' => 'emailSelection'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]); ?> 

                    <div id="emailField" style="display:none"> 
                        <?= $form->field($model, 'email')->textInput() ?>
                    </div>  
                    
<?php } ?>    
 

 
                    <?= $form->field($model, 'mobile')->textInput() ?> 
                    


                    <?= $form->field($model, 'blood_group')->textInput() ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 
                   
                    <?= $form->field($model, 'address_p')->textArea() ?>  
                    <?php

                    echo $form->field($model, 'province_p')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a province ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <?php

                    echo $form->field($model, 'district_p')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\District::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a district ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                    <?php

                    echo $form->field($model, 'municipality_p')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Municipality::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a municipality ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>    
                    <?= $form->field($model, 'ward_p')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_WARDS_ARRAY,
                        'options' => ['placeholder' => 'Select ward ...'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>
 
                </div>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="student-form"> 
                    <?= $form->field($model, 'address_t')->textArea() ?> 
                    <?php

                    echo $form->field($model, 'province_t')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a province ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <?php

                    echo $form->field($model, 'district_t')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\District::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a district ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                    <?php

                    echo $form->field($model, 'municipality_t')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Municipality::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a municipality ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>    
                    <?= $form->field($model, 'ward_t')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_WARDS_ARRAY,
                        'options' => ['placeholder' => 'Select ward ...'],
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


JS;
$this->registerJs($script);
/* end getting the num */
?>
