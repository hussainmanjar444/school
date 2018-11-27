<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BookAuthor */
?>
<div class="book-author-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'name',
            'email:email',
            'contactno',
            'address',
            'details:html',
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
