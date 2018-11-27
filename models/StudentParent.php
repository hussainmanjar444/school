<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_parent".
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property int $status
 * @property string $created_by
 * @property int $created_on
 * @property int $updated_by
 * @property string $updated_on
 */
class StudentParent extends \yii\db\ActiveRecord
{


    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $name;
    public $email;
    public $mobile;
    public $address_p;
    public $address_t;
    public $gender;
    public $blood_group;
    public $province_p;
    public $district_p;
    public $municipality_p;
    public $ward_p;
    public $province_t;
    public $district_t;
    public $municipality_t;
    public $ward_t;
    public $email_selection;
    public $userId;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_parent';
    }

    public function setUserInfo()
    {  
        $profile = $this->getProfile()->one(); 
        $this->userId = $profile->user_id; 
        $this->name = $profile->name;  
       /* $this->email = $profile->user->email; 
        $this->username = $profile->user->username; */
        $this->mobile = $profile->mobile;  
        $this->blood_group = $profile->blood_group;  
        $this->address_t = $profile->address_t;  
        $this->address_p = $profile->address_p;  
        $this->gender = $profile->gender;  
        $this->province_p = $profile->province_p;  
        $this->district_p = $profile->district_p;  
        $this->municipality_p = $profile->municipality_p;  
        $this->ward_p = $profile->ward_p;  
        $this->province_t = $profile->province_t;  
        $this->district_t = $profile->district_t;  
        $this->municipality_t = $profile->municipality_t;  
        $this->ward_t = $profile->ward_t;  
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'name', 'email_selection', 'address_p', 'address_t', 'gender', 'blood_group', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t'], 'required'],
            ['email','email'],
            [['mobile','address_t', 'address_p', 'gender', 'blood_group'], 'string'],
            [['user_id', 'student_id', 'status', 'created_by', 'updated_by', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t'], 'integer'],
            [['created_by', 'updated_on'], 'safe'],
             [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['student_id', 'rollno', 'regno', 'name', 'email_selection', 'address_p', 'address_t', 'gender', 'blood_group', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t'];
        $scenarios[self::SCENARIO_UPDATE] = ['student_id', 'rollno', 'regno', 'name', 'address_p', 'address_t', 'gender', 'blood_group', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t'];
        return $scenarios;
    }

    public function beforeSave($text)
    {
        $this->updated_by = Yii::$app->user->identity->id;
        $this->updated_on = date("Y-m-d H:i:s");
        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->id;
        } 
        return parent::beforeSave($text);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'name' => Yii::t('app', 'Name *'),
            'email' => Yii::t('app', 'Email *'),
            'mobile' => Yii::t('app', 'Mobile'),
            'blood_group' => Yii::t('app', 'Blood group'),
            'address_t' => Yii::t('app', 'Temporary Address *'),
            'address_p' => Yii::t('app', 'Permanent Address *'),
            'gender' => Yii::t('app', 'Gender *'),
            'province_p' => Yii::t('app', 'Province *'),
            'district_p' => Yii::t('app', 'District *'),
            'municipality_p' => Yii::t('app', 'Municipality *'),
            'ward_p' => Yii::t('app', 'Ward *'),
            'province_t' => Yii::t('app', 'Province1 *'),
            'district_t' => Yii::t('app', 'District *'),
            'municipality_t' => Yii::t('app', 'Municipality *'),
            'ward_t' => Yii::t('app', 'Ward *'),
            'email_selection' => Yii::t('app', 'Email Selection *'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\StudentParentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\StudentParentQuery(get_called_class());
    }
}
