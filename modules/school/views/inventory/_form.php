<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">

                <div class="inventory-form">

                    <?php $form = ActiveForm::begin(); ?> 
 

                    <?php

                    echo $form->field($model, 'vendor_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookVendor::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a vendor ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Vendor  '.Html::a('Add New Vendor',''));
                    ?> 

                    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' =>\app\helpers\Configuration::STATUS_ARRAY, 
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-6">

                <div class="book-view">
                    <h1><?= Yii::t('app','Book details') ?></h1>
                    <?= DetailView::widget([
                            'model' => $bookModel,
                            'attributes' => [ 
                                'isbn',
                                'name', 
                                'details:html',
                                'edition',
                                'book_type',
                                'language',
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
                            ],
                        ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
