<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\SchoolAdmin]].
 *
 * @see \app\models\SchoolAdmin
 */
class SchoolAdminQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\SchoolAdmin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\SchoolAdmin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
