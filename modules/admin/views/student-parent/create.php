<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentParent */

$this->title = Yii::t('app', 'Create Student Parent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Parents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-parent-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
