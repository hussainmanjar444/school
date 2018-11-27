<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Profile]].
 *
 * @see \app\models\Profile
 */
class ProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Profile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Profile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
