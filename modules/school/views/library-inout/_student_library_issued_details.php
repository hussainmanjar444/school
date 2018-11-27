<?php

use yii\helpers\Html; 
use yii\widgets\DetailView;
use app\helpers\Configuration;
use app\models\InventoryIssue;  

$this->title = Yii::t('app', 'Student library issued details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Library inout'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;  
$totalIssuedModel = InventoryIssue::find()->select(['id', 'inventory_id'])->where(['student_id' => $studentDetails->student_id])->andWhere(['status' => Configuration::ISSUED])->all();
$totalIssued = count($totalIssuedModel);
$data = []; 
foreach($totalIssuedModel as $value)
{  
    $data = array_merge($data,[$value->inventory_id]); 
} 
$remainingCardLimit = $studentDetails->card_limit - $totalIssued
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-8"> 
                <div class="inventory-issue-form">

                    <?php
                    if($remainingCardLimit == 0)
                    {
                        echo "<h3 style='color:red'><i class='fa fa-warning'></i> Your library card limit is exceed</h3>";
                    }
                    else
                    {
                        echo '<p><a href="/school/inventory-issue/issue-new-book?id='.$studentDetails->student_id.'" class="btn btn-info"><i class="fa fa-plus"></i> Issue New Book</a></p>';
                            /*echo "<h3>NOTE * <i>You can't issue same book twice which is already issued by this student.</i></h3>";
                            $model = new InventoryIssue();
                             $form = ActiveForm::begin([  
                                'action' => '/school/inventory-issue/issue-new-book?id='.$studentDetails->student_id
                             ]); 
                            ?> 

                            <?php 
                                echo $form->field($model, 'inventory_id')->widget(Select2::classname(), [
                                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Inventory::find()->where(['school_id' => $studentDetails->school_id])->andWhere(['status' => Configuration::ACTIVE])->andWhere(['>', 'avaliable_quantity', 0])->andWhere(['not in','id', $data])->all(),'id','bookDetails'),
                                    'options' => ['placeholder' => 'Select a book ...', 'multiple' => true],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'tokenSeparators' => [',', ' '],
                                        'maximumInputLength' => $remainingCardLimit
                                    ],
                                ]);
                            ?> 

                            <?php /*echo $form->field($model, 'issued_date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Enter issued date ...'],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);*/ ?>
                            <?php /* if (!Yii::$app->request->isAjax){ ?>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Issue now') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            <?php } ?>

                            <?php ActiveForm::end(); */?>
                    <?php } ?>
                    
                </div>
                <?php
                   $searchModel = new \app\models\search\InventoryIssueSearch();
                   $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams()); 
                   $dataProvider = new \yii\data\ActiveDataProvider([ 
                    'query' => $dataProvider->query->andFilterWhere(['student_id'=>$studentDetails->student_id])->orderBy("status ASC"),
                    'pagination' => [
                        'pageSize' => 7,
                    ], 
                ]);
                   echo Yii::$app->controller->renderPartial('/inventory-issue/index',[
                       'searchModel' => $searchModel,
                       'dataProvider' => $dataProvider,
                       'model'=>$studentDetails,
                       'remainingCardLimit'=>$remainingCardLimit,
                       'render'=>1
                   ])

                ?>
            </div>
            <div class="col-sm-12 col-md-4">

                <div class="book-view">
                    <h1><?= Yii::t('app','Students details') ?></h1>
                    <p><b> Remaining card limit = <?= $remainingCardLimit ?></b></p>
                    
                    <?= DetailView::widget([
                            'model' => $studentDetails,
                            'attributes' => [  
                                [ 
                                    'label' => Yii::t('app','Student name'),
                                    'value' => function($model) { return $model->student->getName(); }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','School name'),
                                    'value' => function($model) { return $model->school->name; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Library Card number'),
                                    'value' => function($model) { return $model->card_no; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Library inout limit'),
                                    'value' => function($model) { return $model->card_limit; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Class'),
                                    'value' => function($model) { return $model->student->class_id; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Section'),
                                    'value' => function($model) { return $model->student->section; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Roll number'),
                                    'value' => function($model) { return $model->student->rollno; }, 
                                ], 
                                [ 
                                    'label' => Yii::t('app','Registration number'),
                                    'value' => function($model) { return $model->student->regno; }, 
                                ],  
                            ],
                        ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /*
<div class="box"> 
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-8"> 
                <div class="inventory-issue-form">

                    <?php
                    if($remainingCardLimit == 0)
                    {
                        echo "<h1>Your library card limit is exceed</h1>";
                    }
                    else
                    {
                            echo "<h3>NOTE * <i>You can't issue same book twice which is already issued by this student.</i></h3>";
                            $model = new InventoryIssue();
                             $form = ActiveForm::begin([  
                                'action' => '/school/inventory-issue/issue-new-book?id='.$studentDetails->student_id
                             ]); 
                            ?> 

                            <?php 
                                echo $form->field($model, 'inventory_id')->widget(Select2::classname(), [
                                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Inventory::find()->where(['school_id' => $studentDetails->school_id])->andWhere(['status' => Configuration::ACTIVE])->andWhere(['>', 'avaliable_quantity', 0])->andWhere(['not in','id', $data])->all(),'id','bookDetails'),
                                    'options' => ['placeholder' => 'Select a book ...', 'multiple' => true],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'tokenSeparators' => [',', ' '],
                                        'maximumInputLength' => $remainingCardLimit
                                    ],
                                ]);
                            ?> 

                            <?php /*echo $form->field($model, 'issued_date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Enter issued date ...'],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);*/ ?>
                            <?php /* if (!Yii::$app->request->isAjax){ ?>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Issue now') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            <?php } ?>

                            <?php ActiveForm::end(); ?>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
</div> */ ?>
