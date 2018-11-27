<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\StudentLibrary;
use yii\widgets\ActiveForm;
use app\helpers\Configuration;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = $model->user->profile->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box"> 
            <div class="box-body">
                <div class="student-view">
 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php  
                        echo '
                        <a  class = "btn btn-info" href="' . Url::to(['/admin/student/change-password', 'id' => $model->id]) . '">
                        <span title="' . Yii::t('user', 'Update password to school admin') . '" class="glyphicon glyphicon-envelope">
                        </span> ' . Yii::t('user', 'Update password') . '</a>&nbsp;&nbsp;'; 

                        echo "&nbsp;&nbsp;&nbsp;";
                        if ($model->user->isConfirmed) {
                            echo '<b>Account confirmation : </b><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span> ';
                        } else {
                            echo Html::a(Yii::t('user', 'Confirm'), ['/admin/user-action/confirm', 'id' => $model->user->id], [
                                'class' => 'btn btn-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                            ]);
                        }

                     ?>
                        <?php 
                            echo "&nbsp;&nbsp;&nbsp;";
                            if ($model->status == Configuration::ACTIVE) {
                                echo '<b>School confirmation : </b><span class="text-success">' . Yii::t('app', 'Confirmed') . '</span> ';

                                echo Html::a(Yii::t('app', '<i class="fa fa-close"></i> Unconfirm'), ['/admin/student/deactivate-student', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to unconfirm this student?'),
                                ]);
                            } else {
                                echo '<b>School confirmation : </b><span class="text-success">' . Yii::t('app', 'Unconfirmed') . '</span> ';
                                echo Html::a(Yii::t('app', '<i class="fa fa-check"></i> Confirm'), ['/admin/student/activate-student', 'id' => $model->id], [
                                    'class' => 'btn btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this student?'),
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
                            <li class=""><a href="#tab_1-5" data-toggle="tab" aria-expanded="false"><b>Library information</b></a></li> 
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
                                            'value' => function($model) { return $model->schoolName; } 
                                        ], 
                                        'rollno',
                                        'regno', 
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'attribute'=>'class_id', 
                                            'value' => function($model) { return $model->class_id; }
                                        ], 
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'attribute'=>'section', 
                                            'value' => function($model) { return $model->sectionName; }
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

                            <div class="tab-pane " id="tab_1-5">     
                            <div class="row">      
                            <?php
                                $getLibraryModel = StudentLibrary::find()->where(['student_id' => $model->id])->one();
                                if($getLibraryModel)
                                {
                            ?>  
                                <div class="col-sm-12 col-md-6">  
                                    <h1><?= Yii::t('app','Enter student library details'); ?></h1>
                              
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <th>Libyary card number</th>
                                            <th><?= $getLibraryModel->card_no  ?></th> 
                                        </tr>   
                                        <tr>
                                            <th>Library card limit</th>
                                            <th><?= $getLibraryModel->card_limit ?></th> 
                                        </tr>   
                                        <tr>
                                            <th>Created by</th>
                                            <th><?= $getLibraryModel->createdByName  ?></th> 
                                        </tr>   
                                        <tr>
                                            <th>Created on</th>
                                            <th><?= $getLibraryModel->createdOn ?></th> 
                                        </tr>      
                                        <tr>
                                            <th>Updated by</th>
                                            <th><?= $getLibraryModel->updatedByName  ?></th> 
                                        </tr>   
                                        <tr>
                                            <th>Updated on</th>
                                            <th><?= $getLibraryModel->updatedOn ?></th> 
                                        </tr>    
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-6"> 
                                <div class="card">
                                    <div class="header1">
                                        <a href="#" class="logo"><img src="<?= $model->school->avatar; ?>"></a>
                                        <div class="header-right">
                                          <p><?= $model->school->name; ?></p>
                                          <b style="font-size: 0.7em;">Gaur, Rautahat, Nepal</b>
                                        </div> 
                                  </div>
                                  <div class="middle">
                                    <div class="middle-in">
                                      <p>Issued On :</p>
                                    </div>
                                    <div class="middle-right">
                                    <p>
                                        <?php 
                                            $date = strtotime($getLibraryModel->created_on);
                                            echo date("Y-m-d",$date); 
                                        ?>     
                                    </p>
                                    </div>
                                  </div>
                                    <div class="container">
                                      <div class="image">
                                        <img src="<?= $model->avatar; ?>" class="img-thumbnail" alt="Cinque Terre" style="height:130px">
                                     </div>
                                      <div class="para">
                                        <table style="margin-left: 130px;">
                                        <tr>
                                            <th>Name : </th>
                                            <th> &nbsp;&nbsp;<?= $model->user->profile->name; ?></th>
                                        </tr> 
                                        <tr>
                                            <th>ID Crad No : </th>
                                            <th> &nbsp;&nbsp;<?= $getLibraryModel->card_no; ?></th>
                                        </tr>  
                                        <tr>
                                            <th>Class : </th>
                                            <th> &nbsp;&nbsp;<?= $model->class_id; ?></th>
                                        </tr>  
                                        <tr>
                                            <th>Emergency call : </th>
                                            <th> &nbsp;&nbsp;<?= $model->user->profile->mobile; ?></th>
                                        </tr>  
                                        <tr>
                                            <th>Gender : </th>
                                            <th> &nbsp;&nbsp;<?= $model->user->profile->gender; ?></th>
                                        </tr>  
                                        <tr>
                                            <th>Blood Group : </th>
                                            <th> &nbsp;&nbsp;<?= $model->user->profile->blood_group; ?></th>
                                        </tr>      
                                    </table> 
                                        </div>
                                    </div>
                                 <p><button class="button1">POWERED BY <?= strtoupper(\app\helpers\Configuration::getSiteData('site_name')); ?></button></p>
                                </div>
                            </div>
                            <?php 
                            } else { 
 
                            ?>
                            <div class="col-sm-12 col-md-6">  
                            <?php $form = ActiveForm::begin(); ?>
 
 
                                    <?= $form->field($modelStudentLibrary, 'card_limit')->dropDownList(array_combine(range(1, 10), range(1, 10))) ?>
     
                                        <div class="form-group"> 
                                            <?= Html::submitButton(Yii::t('app', 'Assign card'), ['class' => 'btn btn-success']) ?>
                                            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                                        </div> 

                                    <?php ActiveForm::end(); ?>

                            <?php } ?>   
                                </div>  
                            </div>  

                            </div>

                        </div> 
                        <!-- /.tab-pane -->
                    </div>
                    

                </div>
            </div>
        </div>
    </div> 
</div>  