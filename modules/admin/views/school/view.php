<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\Configuration;

/* @var $this yii\web\View */
/* @var $model app\models\School */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box"> 
            <div class="box-body">
                <div class="school-view">
 

                    <p> 
                        <?= Html::a(Yii::t('app', '<i class="fa fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>  <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Add New School'), ['create'], ['class' => 'btn btn-success']) ?>

                        <?php 
                            echo "&nbsp;&nbsp;&nbsp;";
                            if ($model->status == Configuration::ACTIVE) {
                                echo '<b>School confirmation : </b><span class="text-success">' . Yii::t('app', 'Confirmed') . '</span> ';

                                echo Html::a(Yii::t('app', '<i class="fa fa-close"></i> Unconfirm'), ['/admin/school/deactivate-school', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to unconfirm this school?'),
                                ]);
                            } else {
                                echo Html::a(Yii::t('app', '<i class="fa fa-check"></i> Confirm'), ['/admin/school/activate-school', 'id' => $model->id], [
                                    'class' => 'btn btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this school?'),
                                ]);
                            }
                        ?>
                    </p>
                    <hr/>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs ">
                            <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false"><b>School Details</b></a></li>
                           <!--  <li><a href="#tab_1-2" data-toggle="tab" aria-expanded="false">School Admin</a></li>
                            <li class=""><a href="#tab_1-3" data-toggle="tab" aria-expanded="false">Parmanent Teacher</a></li> 
                            <li class=""><a href="#tab_1-4" data-toggle="tab" aria-expanded="false">Temporary Librarian</a></li>  -->
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">  
                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [ 
                                                'name',
                                                'email:email',
                                                'code',
                                                'address:ntext', 
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'province_id',
                                                    'value' => function($model) { return $model->province->name; } 
                                                ],
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'district_id',
                                                    'value' => function($model) { return $model->district->name; } 
                                                ],  
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'municipality_id',
                                                    'value' => function($model) { return $model->municipality->name; } 
                                                ],   
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'ward_no',
                                                    'value' => function($model) { return $model->wardNo; } 
                                                ],    
                                                'established_year',
                                                'website',
                                                'contactno', 
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'status',
                                                    'value' => function($model) { return Configuration::getStatus($model->status); } 
                                                ],   
                                                'added_on', 
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'added_by',
                                                    'value' => function($model) { return $model->addedByName; }
                                                ],
                                                'updated_on', 
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'lastUpdatedBy',
                                                    'value' => function($model) { return $model->updatedByName; }
                                                ],
                                            ],
                                        ]) ?>
                                    </div>
                                    <div class="col-sm-12 col-md-6"> 
                                            <?=  $this->render('_avatarUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?>  
                                    </div>
                                </div>
                                <div class="row"> 
                                    <?= $this->render('_imagesUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?> 
                                </div>
                            </div> 

                            <div class="tab-pane " id="tab_1-2">  
                                
                                school admin

                            </div>

                            <div class="tab-pane " id="tab_1-3">  
                                school teacher
                            </div>

                            <div class="tab-pane " id="tab_1-4"> 

                                school librarian  

                            </div>

                        </div> 
                        <!-- /.tab-pane -->
                    </div>
                    

                </div>
            </div>
        </div>
    </div> 
</div>   
