<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Province */
?>
<div class="province-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'name',
                    ], 
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'created_on',
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'createdBy',
                        'value' => function($model) { return $model->createdByName; }
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'updated_on',
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'lastUpdatedBy',
                        'value' => function($model) { return $model->updatedByName; }
                    ], 
        ],
    ]) ?>

</div>
