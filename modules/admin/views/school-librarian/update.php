<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolLibrarian */

$this->title = Yii::t('app', 'Update School Librarian: ' . $model->user->profile->name, [
    'nameAttribute' => '' . $model->user->profile->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Librarians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->profile->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="school-librarian-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
