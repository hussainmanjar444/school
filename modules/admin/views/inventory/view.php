<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = $model->book->isbn;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?> 

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="box"> 
            <div class="box-body">
                <div class="inventory-view">
 

                    <p> 
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i>  Assign Book To Inventory'), ['search-book'], ['class' => 'btn btn-success']) ?>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> 
                    </p>
                    <hr/>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs ">
                            <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false"><b>Inventory Details</b></a></li>
                            <li><a href="#tab_1-2" data-toggle="tab" aria-expanded="false"><b>Book details</b></a></li> 
                        </ul>
                        <div class="tab-content"> 
                        <?php Pjax::begin(['id' => 'viewInventory']) ?>
                            <div class="tab-pane active" id="tab_1-1">  
                                       <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [ 
                                                [ 
                                                    'label' => 'School',
                                                    'value' => function($model) { return $model->school->name; }, 
                                                ], 
                                                'quantity',
                                                'avaliable_quantity',
                                                [
                                                    'class'=>'\kartik\grid\DataColumn',
                                                    'attribute'=>'status',
                                                    'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); } 
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
                            <?php Pjax::end() ?> 

                            <div class="tab-pane " id="tab_1-2">  
                                  
                                       <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [ 
                                                    'label' => 'Book ISBN',
                                                    'value' => function($model) { return $model->book->isbn; }, 
                                                ],
                                                [ 
                                                    'label' => 'Book Name',
                                                    'value' => function($model) { return $model->book->name; }, 
                                                ],
                                                [ 
                                                    'label' => 'Book Category',
                                                    'value' => function($model) { return $model->book->category->name; }, 
                                                ],
                                                [ 
                                                    'label' => 'Author Name',
                                                    'value' => function($model) { return $model->book->author->name; }, 
                                                ],
                                                [ 
                                                    'label' => 'Publisher Name',
                                                    'value' => function($model) { return $model->book->publisher->name; }, 
                                                ],
                                                [ 
                                                    'attribute' => 'published_year',
                                                    'value' => function($model) { return $model->book->published_year; }, 
                                                ],
                                                [ 
                                                    'attribute' => 'book_type',
                                                    'value' => function($model) { return $model->book->book_type; }, 
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
    <div class="col-sm-12 col-md-4">
        <div class="box"> 
            <div class="box-body">
                <?php
                       $searchModel = new \app\models\search\InventoryHistorySearch();
                       $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
                       $dataProvider->query->andFilterWhere(['inventory_id'=>$model->id]);
                       echo Yii::$app->controller->renderPartial('/inventory-history/index',[
                           'searchModel' => $searchModel,
                           'dataProvider' => $dataProvider,
                           'model'=>$model,
                           'render'=>1
                       ])

                       ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="box"> 
            <div class="box-body">
                <?php
                       $searchModel = new \app\models\search\InventoryLocationSearch();
                       $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
                       $dataProvider->query->andFilterWhere(['inventory_id'=>$model->id]);
                       echo Yii::$app->controller->renderPartial('/inventory-location/index',[
                           'searchModel' => $searchModel,
                           'dataProvider' => $dataProvider,
                           'model'=>$model,
                           'render'=>1
                       ])

                       ?>
            </div>
        </div>
    </div>
</div>   

<?php

$this->registerJs(
   '$("document").ready(function(){ 
        $("#ajaxCrudModal").on("hidden.bs.modal", function() {
            $.pjax.reload({container:"#viewInventory"});  //Reload GridView
        });
    });'
);
?>



