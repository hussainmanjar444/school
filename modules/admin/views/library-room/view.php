<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryRoom */
?>
<div class="library-room-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [ 
                'attribute' => 'school_id',
                'value' => function($model) { return $model->schoolName; },  
            ],
            'name',
            'code',
            'floor',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'created_on',
            ],
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
