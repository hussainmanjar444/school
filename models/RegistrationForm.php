<?php

namespace app\models;

use dektrium\user\models\Profile;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $blood_group;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules(); 
        $rules[] = ['blood_group', 'string', 'max' => 255];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['blood_group'] = \Yii::t('user', 'Blood group');
        return $labels;
    }
 
}