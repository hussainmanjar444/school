<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryRoomRack */
?>
<div class="library-room-rack-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [ 
                'label' => 'School',
                'value' => function($model) { return $model->schoolName; },   
            ],
            [ 
                'attribute' => 'room_id',
                'value' => function($model) { return $model->name; },  
            ],
            'name',
            'code',
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
