<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryFineRule */
?>
<div class="library-fine-rule-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'school_id',
                'value' => function($model) { return $model->school->name; }
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'name',
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'amount',
                'value' => function($model) { return $model->getAmount(); }
            ],
            'details:html', 
            'created_on',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'created_by',
                'value' => function($model) { return $model->createdByName; }, 
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'updated_on',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'updated_by',
                'value' => function($model) { return $model->UpdatedByName; }, 
            ], 
        ],
    ]) ?>

</div>
