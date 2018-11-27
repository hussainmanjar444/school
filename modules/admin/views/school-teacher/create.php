<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolTeacher */

$this->title = Yii::t('app', 'Create School Teacher');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-teacher-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
