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

                        <p>
                            <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Add Student'), ['create'], ['class' => 'btn btn-success']) ?>
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
                                    'label' => Yii::t('app','name'),
                                    'value' => function($model) { return $model->getName(); }
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'school_id', 
                                    'value' => function($model) { return $model->schoolName; },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(\app\models\School::find()->all(),'id' ,'name'),
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Select a class'],
                                    'format' => 'raw'
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
                                    'header' => Yii::t('user', 'Confirmation'),
                                    'value' => function ($model) {
                                        if ($model->user->isConfirmed) {
                                            return '<div class="text-center">
                                                        <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                                                    </div>';
                                        } else {
                                            return Html::a(Yii::t('user', 'Confirm'), ['/admin/user-action/confirm', 'id' => $model->user->id], [
                                                'class' => 'btn btn-xs btn-success btn-block',
                                                'data-method' => 'post',
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                                            ]);
                                        }
                                    },
                                    'format' => 'raw',
                                    'visible' => Yii::$app->getModule('user')->enableConfirmation,
                                ],
                               /* [
                                    'header' => Yii::t('user', 'Block status'),
                                    'value' => function ($model) {
                                        if ($model->user->isBlocked) {
                                            return Html::a(Yii::t('user', 'Unblock'), ['/admin/user-action/block', 'id' => $model->user->id], [
                                                'class' => 'btn btn-xs btn-success btn-block',
                                                'data-method' => 'post',
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                                            ]);
                                        } else {
                                            return Html::a(Yii::t('user', 'Block'), ['/admin/user-action/block', 'id' => $model->user->id], [
                                                'class' => 'btn btn-xs btn-danger btn-block',
                                                'data-method' => 'post',
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                                            ]);
                                        }
                                    },
                                    'format' => 'raw',
                                ],*/

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}  {resend_password} ',
                                    'buttons' => [
                                    'resend_password' => function ($url, $model, $key) { 
                                            return '
                                        <a href="' . Url::to(['/admin/student/change-password', 'id' => $model->id]) . '">
                                        <span title="' . Yii::t('user', 'Update password to school student') . '" class="glyphicon glyphicon-envelope">
                                        </span> </a>'; 
                                    },
                                ]
                                ],
                            ],
                        ]); ?>
                        <?php Pjax::end(); ?>
                    </div>
            </div>
        </div>
    </div>
</div> 
