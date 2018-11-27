<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\LibraryRoom]].
 *
 * @see \app\models\LibraryRoom
 */
class LibraryRoomQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\LibraryRoom[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\LibraryRoom|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
