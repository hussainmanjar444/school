<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolTeacher */

$this->title = Yii::t('app', 'Update School Teacher: ' . $model->user->profile->name, [
    'nameAttribute' => '' . $model->user->profile->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="school-teacher-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
