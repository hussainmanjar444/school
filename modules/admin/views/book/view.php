<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                    <div class="book-view">

                        <h1><?= Html::encode($this->title) ?></h1>

                        <p>
                            <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Add New School'), ['create'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a(Yii::t('app', '<i class="fa fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> 
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [ 
                                'isbn',
                                'name', 
                                'details:html',
                                'edition',
                                [ 
                                    'attribute' => 'author_id',
                                    'value' => function($model) { return $model->author->name; }, 
                                ],
                                [ 
                                    'attribute' => 'publisher_id',
                                    'value' => function($model) { return $model->publisher->name; }, 
                                ],
                                [ 
                                    'attribute' => 'category_id',
                                    'value' => function($model) { return $model->category->name; }, 
                                ], 
                                'published_year',
                                'comment:html',

                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'book_type', 
                                ],   

                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'status',
                                    'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); }
                                ],                       
                                'created_on', 
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'created_by',
                                    'format' => 'html',
                                    'value' => function($model) { return $model->createdByName; }
                                ], 
                                'updated_on',  
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'updated_by',
                                    'format' => 'html',
                                    'value' => function($model) { return $model->UpdatedByName; }
                                ], 
                            ],
                        ]) ?>

                    </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="info-box">
                    <?=  $this->render('_avatarUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="row"> 
    <div class="col-sm-12 col-md-12"> 
        <?= $this->render('_imagesUpload', ['model' => new \app\models\Media(), 'model1' => $model]) ?>
    </div>
</div>
