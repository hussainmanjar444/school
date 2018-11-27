<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\City */
?>
<div class="city-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'province',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
    ]) ?>

</div>
