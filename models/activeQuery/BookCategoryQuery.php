<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\BookCategory]].
 *
 * @see \app\models\BookCategory
 */
class BookCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\BookCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\BookCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
