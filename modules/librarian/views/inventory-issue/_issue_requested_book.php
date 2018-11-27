<?php 
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\InventoryIssue;
use app\helpers\Configuration; 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JsExpression;
use kartik\date\DatePicker;

$studentLibraryInfo = \app\models\StudentLibrary::find()->where(['student_id' => $model->student_id])->one();
$this->title = Yii::t('app','Inssue New Book');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Library inout'), 'url' => ['/librarian/library-inout/']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student library issued details'), 'url' => ['/librarian/library-inout/show-student-library?StudentLibrary[card_no]='.$studentLibraryInfo->card_no]];
$this->params['breadcrumbs'][] = $this->title;  


$totalIssuedModel = InventoryIssue::find()->select(['id', 'inventory_id'])->where(['student_id' => $model->student_id])->andWhere(['status' => Configuration::ISSUED])->all();
$totalIssued = count($totalIssuedModel);
$data = []; 
foreach($totalIssuedModel as $value)
{  
    $data = array_merge($data,[$value->inventory_id]); 
} 
$remainingCardLimit = $studentLibraryInfo->card_limit - $totalIssued
?>
 
<div class="box"> 
	<div class="box-body">
    	<div class="row"> 
 			<div class="col-sm-12 col-md-4"> 
                <div class="inventory-issue-form">
						<?php  
						if($remainingCardLimit == 0)
					    {
					        echo "<h3 style='color:red'><i class='fa fa-warning'></i> Your library card limit is exceed</h3>";
					    } 
                        elseif($model->status == Configuration::ISSUED)
                        {
                            echo "<h3 style='color:red'><i class='fa fa-warning'></i> This book is already issued.</h3>";
                        }
					    else
					    {
                             $form = ActiveForm::begin(); 
                            ?> 
                            <?php
                                echo $form->field($model, 'issue_tilldate')->widget(DatePicker::classname(), [ 
                                    'value' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),
                                    'options' => ['placeholder' => 'Select issue date ...'],
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true
                                    ]
                                ]);
                            ?>
                            <?php  if (!Yii::$app->request->isAjax){ ?>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Issue this book') : Yii::t('app', 'Issue this book'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            <?php } ?>

                            <?php 
                            	ActiveForm::end();
					    }
                             ?>
                </div>
            </div>
 			<div class="col-sm-12 col-md-4"> 
	            <div class="inventory-issue-form"> 
		             <?php
                        $locations = \app\models\InventoryLocation::find()->where(['inventory_id' => $model->inventory_id])->all();
                        if(!empty($locations))
                        {
                            echo "<h3>Book location details</h3>";
                            echo '<ol>';
                            foreach($locations as $location)
                            {
                                echo '<li>';
                                echo $location->room->name." (Room) ==> ".$location->rack->name." (Rack) ==> ".$location->shelf_id." (Shelf)";
                                echo '</li>';
                            }
                            echo '</ol>';
                        }
                        else
                        {
                            echo "<h3>No location is avaliable for this book</h3>";
                        }
                     ?>
		        </div>
		    </div>
 			<div class="col-sm-12 col-md-4"> 
	            <div class="book-view">
                    <h1><?= Yii::t('app','Students details') ?></h1>
                    <p><b> Remaining card limit = <?= $remainingCardLimit ?></b></p>
                    
                    <?= DetailView::widget([
                            'model' => $studentLibraryInfo,
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
 