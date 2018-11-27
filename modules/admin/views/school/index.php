<?php

use yii\helpers\Html; 
use yii\widgets\Pjax;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use app\helpers\Configuration;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'All schools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="school-index">
 
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Create School'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'label'=> Yii::t('app','Logo'),
                                'format' => 'html',
                                'value' => function($model) { return Html::img($model->avatar,[
                                    'width' => '50px',
                                    'height' => '50px',
                                    'class' => 'img-circle'
                                ]); } 
                            ],
                            'name',
                            'email:email', 
                           /* [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'province_id',
                                'value' => function($model) { return $model->province->name; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a province ...'],
                                'format' => 'raw',
                            ],*/
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'district_id',
                                'value' => function($model) { return $model->district->name; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\app\models\District::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a district ...'],
                                'format' => 'raw',
                            ],  
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'municipality_id',
                                'value' => function($model) { return $model->municipality->name; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\app\models\Municipality::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a municipality ...'],
                                'format' => 'raw',
                            ],   
                           /* [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'ward_no',
                                'value' => function($model) { return $model->wardNo; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => Configuration::GET_WARDS_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a ward ...'],
                                'format' => 'raw',
                            ],   */
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'status',
                                'value' => function($model) { return Configuration::getStatus($model->status); },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => Configuration::STATUS_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a status ...'],
                                'format' => 'raw',
                            ],   

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update}'
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
