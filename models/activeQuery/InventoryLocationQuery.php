<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\InventoryLocation]].
 *
 * @see \app\models\InventoryLocation
 */
class InventoryLocationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\InventoryLocation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\InventoryLocation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
