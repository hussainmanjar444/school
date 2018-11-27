<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = Yii::t('app', 'Assign New Book To Inventory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">

    <div class="box-body">
        <div class="row">

        <?php $form = ActiveForm::begin(); ?>
            <div class="col-sm-12 col-md-6">

                <div class="inventroy-form">
 

                    <?= $form->field($model, 'book_id')->textInput(['maxlength' => true,'value' => $isbn,'disabled' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>  
                    <?php

                    echo $form->field($model, 'category_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookCategory::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a book category ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                    <?php

                    echo $form->field($model, 'author_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookAuthor::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a book author ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Author*  '.Html::a('Add New Author',''));
                    ?> 
                    <?php

                    echo $form->field($model, 'publisher_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookPublisher::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a book publisher ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Publisher*  '.Html::a('Add New Publisher',''));
                    ?>  

                     <?php echo $form->field($model, 'published_year')->widget(etsoft\widgets\YearSelectbox::classname(), [
                        'yearStart' => 1900,
                        'yearStartType' => 'fix',
                        'yearEnd' => 2080,
                        'yearEndType' => 'fix',
                     ]);
                    ?> 

                    
                    <?php

                    echo $form->field($model, 'vendor_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\BookVendor::find()->all(),'id','name'),
                        'options' => ['placeholder' => 'Select a vendor ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 

                    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
 

                </div>
            </div>
            <div class="col-sm-12 col-md-6">

                <div class="inventroy-form"> 
                    <?= $form->field($model, 'details')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ]) ?> 

                    <?= $form->field($model, 'edition')->textInput() ?>
 
 

                    <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?>

                   <?= $form->field($model, 'book_type')->widget(Select2::classname(), [
                    'data' =>\app\helpers\Configuration::GET_BOOK_TYPE_ARRAY,
                    'options' => ['placeholder' => 'Select a book type ...'],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>

                   <?= $form->field($model, 'language')->widget(Select2::classname(), [
                    'data' =>\app\helpers\Configuration::GET_BOOK_LANGUAGE_ARRAY, 
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>

                   <?= $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' =>\app\helpers\Configuration::STATUS_ARRAY, 
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                    </div>

                </div>
            </div>

                    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> 
