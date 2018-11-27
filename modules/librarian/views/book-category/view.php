<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BookCategory */
?>
<div class="book-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [
                'attribute'=>'parent_id',
                'value' => function ($model) {
                    return (!empty($model->parentCategory->name)) ? ucfirst($model->parentCategory->name) : "N/A";
                },
                'format' => 'raw',

                'visible' => ($model->getParentCategory()->count() > 0) ? true : false

            ],
            'name',
            'details:html',
            'created_on', 
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'created_by',
                'format' => 'html',
                'value' => function($model) { return $model->createdByName; }
            ], 
            'updated_on',  
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'updated_by',
                'format' => 'html',
                'value' => function($model) { return $model->UpdatedByName; }
            ], 
        ],
    ]) ?>

</div>
