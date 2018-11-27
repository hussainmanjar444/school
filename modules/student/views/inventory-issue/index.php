<?php
use yii\helpers\Html;
use kartik\grid\GridView;  
use yii\widgets\Pjax;
use app\helpers\Configuration; 
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Library History');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="inventory-issue-index">
 
                    <?php Pjax::begin(); ?> 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Request New book'), ['search-book'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
 
                            [ 
                                'label' => 'Book ISBN',
                                'value' => function($model) { return $model->inventory->book->isbn; }, 
                            ],
                            [ 
                                'label' => 'Book ISBN',
                                'value' => function($model) { return $model->inventory->book->name; }, 
                            ], 
                            'request_date',
						    [
						        'class'=>'\kartik\grid\DataColumn',
						        'attribute'=>'issued_date',
						        'value' => function($model){ 
						            return ($model->status == Configuration::PENDING) ? Configuration::getStatus($model->status) : $model->issued_date;
						        }
						    ],  
						    [
						        'class'=>'\kartik\grid\DataColumn',
						        'attribute'=>'issue_tilldate',
						        'value' => function($model){ 
						            return ($model->status == Configuration::PENDING) ? Configuration::getStatus($model->status) : $model->issue_tilldate;
						        }
						    ],
						    [
						        'class'=>'\kartik\grid\DataColumn',
						        'attribute'=>'status',
						        'value' => function($model){  return ($model->status == Configuration::ISSUED) ? '<b style="color:red">'.Configuration::getStatus($model->status).'</b>' : '<b style="color:green">'.Configuration::getStatus($model->status).'</b>'; } ,
						        'filterType' => GridView::FILTER_SELECT2,
						        'filter' => Configuration::LIBRARY_STATUS_ARRAY,
						        'filterWidgetOptions' => [
						            'pluginOptions' => ['allowClear' => true],
						        ],
						        'filterInputOptions' => ['placeholder' => 'status'],
						        'format' => 'raw'
						    ],  
                            [
                                'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
