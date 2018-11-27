<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 *
 * @property Packages[] $packages
 * @property Packages[] $packages0
 * @property User $user
 */
class User extends BaseUser
{  
    const UPDATE_ACCOUNT = "update_account";
	
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();   
        $rules[] = ['password', 'required']; 
        $rules[] = ['confirm_password', 'string', 'max' => 255];
        $rules[] = [['confirm_password','password'], 'validatePassword' , 'when' => function () {
                if (isset($this->confirm_password)) {
                    return true;
                }
            }];
 
        return $rules;
    }

    public function validatePassword()
    {     
        if($this->password != $this->confirm_password){ 
            return $this->addError('confirm_password',Yii::t('app','Password and confirm password not match'));
        } 
    } 



   public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::UPDATE_ACCOUNT] = ['confirm_password', 'password']; 
        return $scenarios;
    }

     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels(); 
        $labels['confirm_password'] = Yii::t('app', 'Confirm password');  
        return $labels;
    } 



}
