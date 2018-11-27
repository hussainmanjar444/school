<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[Inventory]].
 *
 * @see Inventory
 */
class InventoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Inventory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Inventory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
