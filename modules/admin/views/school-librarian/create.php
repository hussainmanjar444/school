<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = Yii::t('app', 'Create Librarian');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School-librarian'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-create"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
