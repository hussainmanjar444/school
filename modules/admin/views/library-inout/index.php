<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\select2\Select2;
 
$this->title = Yii::t('app','Library inout'); 
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
        <div class="row">
            <div class="login-box" style="margin: 0% auto;">
                <div class="login-box-body">
                    <p class="login-box-msg"><b>Search Library Student </b></p> 
                     <p class="login-box-msg"><b><?= @$msg; ?></b></p>  
                        <?php $form = ActiveForm::begin([
                            'method' => 'get',
                            'action' => '/admin/library-inout/show-student-library',
                        ]); ?>  

                                <?= $form->field($model, 'card_no')->textInput() ?>
                                
                                <div class="form-group"> 
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-search"></i> Search Library Card'), ['class' => 'btn btn-success btn-flat','options'=> ['height' => '34px']]) ?> 
                                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?> 
                                </div> 
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </section>