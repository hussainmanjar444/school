<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\School */

$this->title = Yii::t('app', 'Create School');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-create">
 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
