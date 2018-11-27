<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\StudentLibrary; 
use app\helpers\Configuration;
use app\models\InventoryIssue;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = Yii::t('app', 'My school'); 
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box"> 
            <div class="box-body">
                <div class="student-view"> 
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs "> 
                            <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false"><b>School details</b></a></li> 
                            <li class=""><a href="#tab_1-2" data-toggle="tab" aria-expanded="false"><b>Library information</b></a></li> 
                        </ul>
                        <div class="tab-content"> 

                            <div class="tab-pane active" id="tab_1-1">  

                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [   
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'attribute'=>'school_id', 
                                            'value' => function($model) { return $model->schoolName; } 
                                        ],  
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","School code"), 
                                            'value' => function($model) { return $model->school->code; } 
                                        ], 
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Established year"), 
                                            'value' => function($model) { return $model->school->established_year; } 
                                        ],   
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Website"), 
                                            'value' => function($model) { return $model->school->website; } 
                                        ],  
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Contact no"), 
                                            'value' => function($model) { return $model->school->contactno; } 
                                        ],    
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Address"), 
                                            'value' => function($model) { return $model->school->address; } 
                                        ],    
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Ward"), 
                                            'value' => function($model) { return $model->school->wardNo; } 
                                        ], 
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","Municipality"), 
                                            'value' => function($model) { return $model->school->municipality->name; } 
                                        ],    
                                        [
                                            'class'=>'\kartik\grid\DataColumn',
                                            'label'=>Yii::t("app","District"), 
                                            'value' => function($model) { return $model->school->district->name; } 
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

                            <div class="tab-pane " id="tab_1-2">     
                            <div class="row">      
                            <?php
                                $getLibraryModel = StudentLibrary::find()->where(['student_id' => $model->id])->one();
                                if($getLibraryModel)
                                {
                            ?>  
                                <div class="col-sm-12 col-md-6">  
                                    <h1><?= Yii::t('app','Library details'); ?></h1>
                              
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <th>Libyary card number</th>
                                            <th><?= $getLibraryModel->card_no  ?></th> 
                                        </tr>   
                                        <tr>
                                            <th>Total card limit </th>
                                            <th><?= $getLibraryModel->card_limit ?></th> 
                                        </tr>    
                                        <tr>
                                            <th>Current limit</th>
                                            <th>
                                                <?php $totalIssued = InventoryIssue::find()->select(['id'])->where(['student_id' =>  \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->andWhere(['status' => Configuration::ISSUED])
                                                ->all(); ?>
                                                <?= $getLibraryModel->card_limit - count($totalIssued); ?>
                                                    
                                            </th> 
                                        </tr>    
                                        <tr>
                                            <th> Total issued book</th>
                                            <th>
                                                <?= count($totalIssued); ?>
                                            </th> 
                                        </tr>   
                                        <tr>
                                            <th>Created on</th>
                                            <th><?= $getLibraryModel->createdOn ?></th> 
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
                            <?php  }  else { echo "<center><h1>Looks like you don’t have library card issued. Please contact your school librarian or Admin Department. </h1></center>"; }?>   
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