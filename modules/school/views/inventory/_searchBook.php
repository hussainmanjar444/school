<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 

/* @var $this yii\web\View */
/* @var $model app\models\SearchBook */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app','Search Book');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
		<div class="row">
			<div class="login-box" style="margin: 0% auto;">
				<div class="login-box-body">
					<p class="login-box-msg"><b>Search Book By ISBN</b></p>
					<p> <?= $msg; ?> </p>
					<?php $form = ActiveForm::begin(['method' => 'get']); ?> 
							<?= $form->field($model, 'isbn')->textInput(['maxlength' => true,'class' => "form-control",'required' => true])->label(false) ?>
								
								<div class="form-group"> 
			                        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-search"></i> Search Book'), ['class' => 'btn btn-success btn-flat','options'=> ['height' => '34px']]) ?> 
                        			<?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?> 
			                    </div> 
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</section>