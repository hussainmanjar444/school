<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InventoryHistory */
?>
<div class="inventory-history-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'quantity',
            [ 
                'label' => 'Vendor name',
                'value' => function($model) { return $model->vendor->name; }, 
            ],
            'amount',
            'comment:ntext',
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Created by'),
                'value' => function($model) { return $model->createdByName; }
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'created_on',
                'value' => function($model) { return $model->createdOn; }
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Updated by'),
                'value' => function($model) { return $model->updatedByName; }
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'updated_on',
                'value' => function($model) { return $model->updatedOn; }
            ], 
        ],
    ]) ?>

</div>
