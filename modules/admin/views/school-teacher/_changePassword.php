<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolAdmin */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app','Update account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Teacher'), 'url' => ['index']];
$this->params["breadcrumbs"][] = $this->title;
?>

<div class="box">

    <div class="box-body">
        <div class="row">

            <?php $form = ActiveForm::begin(); ?>   
            <div class="col-sm-4 col-md-4">

                <div class="school-admin-form">  
                    <?= $form->field($model, 'password')->passwordInput() ?>  
                    <?= $form->field($model, 'confirm_password')->passwordInput() ?>  

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                    </div>

                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> 
 


 