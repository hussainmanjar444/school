<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\School */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">

    <div class="box-body">
        <div class="row">

        <?php $form = ActiveForm::begin(); ?>
            <div class="col-sm-12 col-md-6">

                <div class="school-form">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true,
                        'onchange'=>'
                                    $.post( "/admin/common/check-duplicate-user?email="+$(this).val(), function( data ) {
                                      $( "#duplicateUser" ).html( data );
                                    });',
                        ]) ?>

                    <span id="duplicateUser"></span>    
<?php if($model->isNewRecord){ ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?php } ?>                    
 
                    <?php echo $form->field($model, 'established_year')->widget(etsoft\widgets\YearSelectbox::classname(), [
                        'yearStart' => 1900,
                        'yearStartType' => 'fix',
                        'yearEnd' => 2080,
                        'yearEndType' => 'fix',
                     ]);
                    ?>

                    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'contactno')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-6">

                <div class="school-form"> 

                    <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>

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
                            'options' => [
                                'placeholder' => 'Select district ...',
                                'id' => 'district',
                                'onchange'=>'
                                    $.post( "/admin/common/get-municipality?id="+$(this).val(), function( data ) {
                                      $( "select#municipality" ).html( data );
                                    });',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?> 
                     <?php 
                        if($model->isNewRecord) { $data = []; } 
                        else { $data = ArrayHelper::map(\app\models\Municipality::find()->where(['district_id' => $model->district_id])->all(),'id','name'); }
                        echo $form->field($model, 'municipality_id')->widget(Select2::class, [
                            'data' => $data,
                            'options' => [
                                'placeholder' => 'Select municipality ...',
                                'id' => 'municipality',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?> 
   
  
                    <?= $form->field($model, 'ward_no')->widget(Select2::classname(), [
                        'data' =>\app\helpers\Configuration::GET_WARDS_ARRAY,
                        'options' => ['placeholder' => 'Select ward no ...'],
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


 