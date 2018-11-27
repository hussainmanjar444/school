<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolAdmin */

$this->title = Yii::t('app', 'Create School Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-admin-create"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
