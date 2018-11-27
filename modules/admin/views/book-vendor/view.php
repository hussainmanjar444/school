<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BookVendor */
?>
<div class="book-vendor-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'contactno',
            'address',
            'details:ntext',
            'website',
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
