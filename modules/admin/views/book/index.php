<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use app\models\Book;
use app\helpers\Configuration;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="book-index">
 
                    <?php Pjax::begin(); ?> 

                    <p>
                        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i>  Add New Book'), ['create'], ['class' => 'btn btn-success']) ?> &nbsp;&nbsp;&nbsp;
                        <?= Yii::t('app','Total Books : ') ?><?= count(Book::find()->all()); ?>&nbsp;&nbsp;&nbsp;
                        <?= Yii::t('app','Active : ') ?><?= count(Book::find()->where(['status' => Configuration::ACTIVE])->all()); ?>&nbsp;&nbsp;&nbsp;
                        <?= Yii::t('app','Inactive : ') ?><?= count(Book::find()->where(['status' => Configuration::INACTIVE])->all()); ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'], 
 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'label'=> Yii::t('app','Logo'),
                                'format' => 'html',
                                'value' => function($model) { return Html::img($model->avatar,[
                                    'width' => '50px',
                                    'height' => '50px',
                                    'class' => 'img-circle'
                                ]); } 
                            ],
                            'isbn',
                            'name',  
                            [ 
                                'attribute' => 'author_id',
                                'value' => function($model) { return $model->author->name; }, 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\BookAuthor::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a book author ...'],
                                'format' => 'raw',
                            ],
                            [ 
                                'attribute' => 'publisher_id',
                                'value' => function($model) { return $model->publisher->name; }, 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\BookPublisher::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a book publisher ...'],
                                'format' => 'raw',
                            ],
                            [ 
                                'attribute' => 'category_id',
                                'value' => function($model) { return $model->category->name; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\BookCategory::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a book category ...'],
                                'format' => 'raw',                            
                            ], 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'book_type',
                                'value' => function($model) { return $model->book_type; },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => Configuration::GET_BOOK_TYPE_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Book type'],
                                'format' => 'raw'
                            ],  
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'status',
                                'value' => function($model) { return Configuration::getStatus($model->status); },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => Configuration::STATUS_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'status'],
                                'format' => 'raw'
                            ],  

                            [
                                'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
