<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\helpers\Configuration;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolAdmin */

$this->title = $model->user->profile->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box"> 
            <div class="box-body">
                <div class="school-admin-view">
 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])   ?>

                    &nbsp;&nbsp;&nbsp;
                     <?php 
                        if ($model->user->isConfirmed) {
                            echo '<b>Account confirmation : </b><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span> ';
                        } else {
                            echo '<b>Account confirmation : </b><span class="text-success">' . Yii::t('user', 'Not Confirmed') . '</span> ';
                        }
                     ?>
                        <?php 
                            echo "&nbsp;&nbsp;&nbsp;";
                            if ($model->status == Configuration::ACTIVE) {
                                echo '<b>School confirmation : </b><span class="text-success">' . Yii::t('app', 'Confirmed') . '</span> ';

                                echo Html::a(Yii::t('app', '<i class="fa fa-close"></i> Unconfirm'), ['/school/school-admin/deactivate-school-admin', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to unconfirm this admin for school?'),
                                ]);
                            } else {
                                echo '<b>School confirmation : </b><span class="text-success">' . Yii::t('app', 'Unconfirmed') . '</span> ';
                                echo Html::a(Yii::t('app', '<i class="fa fa-check"></i> Confirm'), ['/school/school-admin/activate-school-admin', 'id' => $model->id], [
                                    'class' => 'btn btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this  admin for school?'),
                                ]);
                            }
                        ?>

                    </p>
                    <hr/>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs ">
                            <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false"><b>Profile</b></a></li>
                            <li><a href="#tab_1-2" data-toggle="tab" aria-expanded="false"><b>School details</b></a></li>
                            <li class=""><a href="#tab_1-3" data-toggle="tab" aria-expanded="false"><b>Parmanent Address</b></a></li> 
                            <li class=""><a href="#tab_1-4" data-toggle="tab" aria-expanded="false"><b>Temporary Address</b></a></li> 
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1-1"> 
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"> 
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [   
                                        [
                                            'label' => yii::t('app','Name'),
                                            'value' => function($model) { return $model->user->profile->name; }
                                        ],
                                        [
                                            'label' => yii::t('app','Email'),
                                            'value' => function($model) { return $model->user->email; }
                                        ], 
                                        [
                                            'attribute' => 'username',
                                            'value' => function($model) { return $model->user->username; }
                                        ], 
                                        [
                                            'attribute' => 'mobile',
                                            'value' => function($model) { return $model->user->profile->mobile; }
                                        ],  
                                        [
                                            'attribute' => 'gender',
                                            'value' => function($model) { return $model->user->profile->gender; }
                                        ],  
                                        [
                                            'attribute' => 'blood_group',
                                            'value' => function($model) { return $model->user->profile->blood_group; }
                                        ],  
                                        [
                                          'label' => 'Last login at',
                                          'value' => function ($model) {
                                            if (!$model->user->last_login_at || $model->user->last_login_at == 0) {
                                                return Yii::t('user', 'Never');
                                            } else if (extension_loaded('intl')) {
                                                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->user->last_login_at]);
                                            } else {
                                                return date('Y-m-d G:i:s', $model->user->last_login_at);
                                            }
                                          },
                                        ],
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
                            <div class="col-sm-12 col-md-6"> 
                                    <?=  $this->render('_avatarUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?>  
                            </div>
                        </div>
                    </div>

                            <div class="tab-pane " id="tab_1-2">  

                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [   
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'attribute'=>'school_id', 
                                            'value' => function($model) { return $model->school->name; } 
                                        ], 
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'attribute'=>'status',
                                            'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); } 
                                        ],    
                                    ],
                                ]) ?>

                            </div>

                            <div class="tab-pane " id="tab_1-3">  
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [   
                                        [
                                            'label' => yii::t('app','Parmanent address'),
                                            'value' => function($model) { return $model->user->profile->address_p; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Province'),
                                            'value' => function($model) { return $model->user->profile->provincePermanentName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','District'),
                                            'value' => function($model) { return $model->user->profile->districtPermanentName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Municipality'),
                                            'value' => function($model) { return $model->user->profile->municipalityPermanentName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Ward'),
                                            'value' => function($model) { return $model->user->profile->wardPermanent; }
                                        ], 
                                    ],
                                ]) ?>

                            </div>

                            <div class="tab-pane " id="tab_1-4">  
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [   
                                        [
                                            'label' => yii::t('app','Parmanent address'),
                                            'value' => function($model) { return $model->user->profile->address_t; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Province'),
                                            'value' => function($model) { return $model->user->profile->provinceTemporaryName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','District'),
                                            'value' => function($model) { return $model->user->profile->districtTemporaryName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Municipality'),
                                            'value' => function($model) { return $model->user->profile->municipalityTemporaryName; }
                                        ], 
                                        [
                                            'label' => yii::t('app','Ward'),
                                            'value' => function($model) { return $model->user->profile->wardTemporary; }
                                        ], 
                                    ],
                                ]) ?>

                            </div>

                        </div> 
                        <!-- /.tab-pane -->
                    </div>
                    

                </div>
            </div>
        </div>
    </div> 
</div>   