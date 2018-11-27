<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inventories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="inventory-index">
 
                    <?php Pjax::begin(); ?> 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i>  Assign Book To Inventory'), ['search-book'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
 
                            [ 
                                'label' => 'Book ISBN',
                                'value' => function($model) { return $model->book->isbn; }, 
                            ],
                            [ 
                                'label' => 'Book Name',
                                'value' => function($model) { return $model->book->name; }, 
                            ],
                            [ 
                                'label' => 'School',
                                'value' => function($model) { return $model->school->name; }, 
                            ], 
                            'quantity',
                            'avaliable_quantity',
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'status',
                                'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \app\helpers\Configuration::STATUS_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'status'],
                                'format' => 'raw'
                            ],  
                            [
                                'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
