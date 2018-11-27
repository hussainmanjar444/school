<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = Yii::t('app', 'Update Inventory: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">

				<div class="inventory-update"> 
					<?php $form = ActiveForm::begin(); ?>

					    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'avaliable_quantity')->textInput(['maxlength' => true]) ?>

					    <?= $form->field($model, 'status')->widget(Select2::classname(), [
		                    'data' =>\app\helpers\Configuration::STATUS_ARRAY,
		                    'options' => ['placeholder' => 'Select status ...'],
		                    'pluginOptions' => [
		                        'allowClear' => false
		                    ],
		                ]);?>  

					  
						<?php if (!Yii::$app->request->isAjax){ ?>
						  	<div class="form-group">
						        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
						    </div>
						<?php } ?>

					    <?php ActiveForm::end(); ?>
				    

				</div>
			</div>
		</div>
	</div>
</div>
