<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentParent */

$this->title = Yii::t('app', 'Update Student Parent: ' . $model->user->profile->name, [
    'nameAttribute' => '' . $model->user->profile->name,,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Parents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="student-parent-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
