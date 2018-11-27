<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\Configuration;

/* @var $this yii\web\View */
/* @var $model app\models\InventoryIssue */ 
$this->title = $model->inventory->book->isbn;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Library History'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="inventory-issue-index"> 
                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Request new book'), ['search-book'], ['class' => 'btn btn-success']) ?>
                    </p>
 
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [  
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'label'=>'Book',
                                'value' => function($model){ return $model->inventory->book->isbn.' - '.$model->inventory->book->name;}
                            ], 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'issued_date',
                                'value' => function($model){ 
                                    return ($model->status == Configuration::PENDING) ? Configuration::getStatus($model->status) : $model->issued_date;
                                }
                            ],  
                            'request_date',
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
                                'value' => function($model){ return Configuration::getStatus($model->status); }
                            ],       
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'actual_fine',
                                'value' => function($model){  
                                    return ($model->status == Configuration::RETURNED) ? $model->actual_fine : Yii::t('app', 'Not returned');
                                }
                            ],      
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'collected_fine',
                                'value' => function($model){  
                                    return ($model->status == Configuration::RETURNED) ? $model->collected_fine : Yii::t('app', 'Not returned');
                                }
                            ],   
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'issue_by',
                                'value' => function($model){ 
                                    return ($model->status == Configuration::PENDING) ? Configuration::getStatus($model->status) : $model->issueByName;
                                }
                            ],   
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'recieved_by',
                                'value' => function($model){ 
                                    return ($model->status == Configuration::RETURNED) ? $model->receivedByName : Yii::t('app', 'Not returned'); 
                                }
                            ],         
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
