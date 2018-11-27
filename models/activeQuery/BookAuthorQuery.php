<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\BookAuthor]].
 *
 * @see \app\models\BookAuthor
 */
class BookAuthorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\BookAuthor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\BookAuthor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
