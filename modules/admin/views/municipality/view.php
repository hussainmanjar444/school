<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipality */
?>
<div class="municipality-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'name',
            
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'province_id',
                'value' => function($model) { return $model->province->name; }, 
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'district_id',
                'value' => function($model) { return $model->district->name; }, 
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
