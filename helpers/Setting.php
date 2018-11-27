<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 4/13/2018
 * Time: 11:29 AM
 */

namespace app\helpers;

use yii\helpers\ArrayHelper;

class Setting
{

    private $config = null;

    public function __construct()
    {
        $config = Configuration::find()->asArray()->all();
        if ($config != null) {
            $this->config = ArrayHelper::index($config, 'name');
        }


    }

    public function getConfig()
    {

        return $this->config;
    }


}