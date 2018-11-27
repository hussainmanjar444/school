<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[StudentLibrary]].
 *
 * @see StudentLibrary
 */
class StudentLibraryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StudentLibrary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StudentLibrary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
