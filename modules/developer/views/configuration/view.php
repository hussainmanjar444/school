<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\helpers\Configuration */
?>
<div class="configuration-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'value:ntext',
            'can_update_value',
        ],
    ]) ?>

</div>
