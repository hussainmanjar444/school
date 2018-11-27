<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\select2\Select2;
 
$this->title = Yii::t('app','Student record not found'); 
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
        <div class="row">
            <div class="login-box" style="margin: 0% auto;">
                <div class="login-box-body">
                    <p class="login-box-msg"><b><?= @$msg; ?></b></p>  
                </div>
            </div>
        </div>
    </section>