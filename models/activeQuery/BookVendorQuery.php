<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[BookVendor]].
 *
 * @see BookVendor
 */
class BookVendorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BookVendor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BookVendor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
