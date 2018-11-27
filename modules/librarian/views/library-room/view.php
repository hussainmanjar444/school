<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LibraryRoom */ 
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Library Rooms'), 'url' => ['index']];
?>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="box"> 
            <div class="box-body">
                <div class="library-room-view">
                 
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [  
                            'name',
                            'code',
                            'floor',
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'created_on',
                            ],
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'created_by',
                                'value' => function($model) { return $model->createdByName; }, 
                            ], 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'updated_on',
                            ],
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'updated_by',
                                'value' => function($model) { return $model->UpdatedByName; }, 
                            ], 
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
            <div class="box"> 
                <div class="box-body">
                    <?php
                           $searchModel = new \app\models\search\LibraryRoomRackSearch();
                           $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
                           $dataProvider->query->andFilterWhere(['room_id'=>$model->id]);
                           echo Yii::$app->controller->renderPartial('/library-room-rack/index',[
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
