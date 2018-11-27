<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\select2\Select2;
 
$this->title = Yii::t('app','Manage Library In/Out'); 
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
        <div class="row">
            <div class="login-box" style="margin: 0% auto;">
                <div class="login-box-body"> 
                     <span class="login-box-msg"><b><?= @$msg; ?></b></span>  
                        <?php $form = ActiveForm::begin([
                            'method' => 'get',
                            'action' => '/librarian/library-inout/show-student-library',
                        ]); ?>  

                                <?= $form->field($model, 'card_no')->textInput()->label("Search by Library Card No. or Student ID No") ?>
                                
                                <div class="form-group"> 
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-search"></i> Search Library Card'), ['class' => 'btn btn-success btn-flat','options'=> ['height' => '34px']]) ?> 
                                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?> 
                                </div> 
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </section>