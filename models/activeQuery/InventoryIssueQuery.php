<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\InventoryIssue]].
 *
 * @see \app\models\InventoryIssue
 */
class InventoryIssueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\InventoryIssue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\InventoryIssue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
