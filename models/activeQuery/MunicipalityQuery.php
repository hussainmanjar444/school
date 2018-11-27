<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Municipality]].
 *
 * @see \app\models\Municipality
 */
class MunicipalityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Municipality[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Municipality|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
