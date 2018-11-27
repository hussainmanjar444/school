<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>
 

<div class="row"> 
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?> 

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?> 
                <div class="form-group">
                    <div class="col-lg-offset-0 col-lg-4">
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton(Yii::t('user', 'Reset'), ['class' => 'btn btn-default']) ?><br>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div> 
    </div>
</div>
