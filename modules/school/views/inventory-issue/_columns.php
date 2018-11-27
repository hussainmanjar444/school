<?php
use yii\helpers\Url;
use kartik\grid\GridView;  
use app\helpers\Configuration; 
use yii\helpers\Html;  
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Book',
        'value' => function($model){ return $model->inventory->book->isbn.' - '.$model->inventory->book->name;}
    ], 
    'request_date',
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'issued_date',
        'value' => function($model){ 
            return ($model->status == Configuration::PENDING) ? Configuration::getStatus($model->status) : $model->issued_date;
        }
    ],  
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
        'value' => function($model){ 
            if($model->status == Configuration::PENDING){
                if($GLOBALS['remainingCardLimit'] == 0)
                {
                    return '<b style="color:red">In out limit exceed';
                }
                return '<b style="color:blue">'.Configuration::getStatus($model->status).'</b><br/><b><a data-method="POST" target="_blank" data-confirm="'. Yii::t("app", "Are you sure you want to issue this book?").'"  href="' . Url::to(['/school/inventory-issue/issue-requested-book', 'id' => $model->id]) . '">Issued now</a></b>'; 
            }
            if($model->status == Configuration::ISSUED)
            {
                if(date("Y-m-d") < $model->issue_tilldate)
                {
                    return '<b style="color:red">'.Configuration::getStatus($model->status).'</b><br/><b><a data-method="POST" data-confirm="'. Yii::t("app", "Are you sure you want to receive this book?").'"  href="' . Url::to(['/school/inventory-issue/receive-without-late-fee', 'id' => $model->id]) . '">Receive now</a></b>';
                } 
                else
                {
                     return '<b style="color:red">'.Configuration::getStatus($model->status).' </b><br/><b>'.Html::a('Receive now', ['/school/inventory-issue/receive-with-late-fee?id='.$model->id],
                    ['role'=>'modal-remote','title'=> 'Receive book now']).'</b>';
                }
            }
            else
            {
                return '<b style="color:green">'.Configuration::getStatus($model->status).'</b>';
            }
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => Configuration::LIBRARY_STATUS_ARRAY,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'status'],
        'format' => 'raw'
    ],  
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => "{view}",
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to(['/school/inventory-issue/'.$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   

?>
 