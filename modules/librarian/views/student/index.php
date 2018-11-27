<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                    <div class="student-index"> 
                        <?php Pjax::begin(); ?> 

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'], 
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label'=> Yii::t('app','Profile'),
                                    'format' => 'html',
                                    'value' => function($model) { return Html::img($model->avatar,[
                                            'width' => '50px',
                                            'height' => '50px',
                                            'class' => 'img-circle'
                                    ]); } 
                                ],
 
                                [
                                    'label' => Yii::t('app','name'),
                                    'value' => function($model) { return $model->getName(); }
                                ], 
                                'rollno',
                                'regno', 
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'class_id', 
                                    'value' => function($model) { return $model->class_id; },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => \app\helpers\Configuration::GET_CLASS_ARRAY,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Select a class'],
                                    'format' => 'raw'
                                ], 
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'section', 
                                    'value' => function($model) { return $model->sectionName; },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => \app\helpers\Configuration::GET_SECTION_ARRAY,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Select a class'],
                                    'format' => 'raw'
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'status',
                                    'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => \app\helpers\Configuration::STATUS_ARRAY,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'School status'],
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
