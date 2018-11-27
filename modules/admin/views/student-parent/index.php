<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentParentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Student Parents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                    <div class="student-index">
                            <?php Pjax::begin(); ?>
                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                            <p>
                                <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Add Student Parent'), ['create'], ['class' => 'btn btn-success']) ?>
                            </p>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    'user_id',
                                    'student_id',
                                    'status',
                                    'created_by',
                                    //'created_on',
                                    //'updated_by',
                                    //'updated_on',
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
                                [
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
                                ],

                                    ['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        </div>

            </div>
        </div>
    </div>
</div> 

