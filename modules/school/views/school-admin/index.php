<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SchoolAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'School Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="school-admin-index">
                    <?php Pjax::begin(); ?> 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Add School Admin'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

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
                                'label' => Yii::t('app','Name'),
                                'value' => function($model) { return $model->user->profile->name; }
                            ],
                            [
                                'label' => Yii::t('app','Email'),
                                'value' => function($model) { return $model->user->email; }
                            ],
                            [
                                'label' => Yii::t('app','Username'),
                                'value' => function($model) { return $model->user->username; }
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
                                'header' => Yii::t('user', 'Confirmation'),
                                'value' => function ($model) {
                                    if ($model->user->isConfirmed) {
                                        return '<div class="text-center">
                                                    <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                                                </div>';
                                    } else {
                                        return '<div class="text-center">
                                                    <span class="text-danger">' . Yii::t('user', 'Account Not Confirmed') . '</span>
                                                </div>';
                                    }
                                }, 
                                'format' => 'raw', 
                            ], 

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} ', 
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
