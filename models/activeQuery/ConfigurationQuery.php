<?php

namespace app\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Configuration]].
 *
 * @see \app\models\Configuration
 */
class ConfigurationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Configuration[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Configuration|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
