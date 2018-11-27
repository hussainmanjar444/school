<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InventoryLocation */
?>
<div class="inventory-location-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'inventory_id',
            'room_id',
            'rack_id',
            'shelf_id',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
        ],
    ]) ?>

</div>
