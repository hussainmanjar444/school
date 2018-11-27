<?php

namespace app\models;

use Yii;
use app\helpers\Configuration;
use yii\helpers\Url;
use app\helpers\Encription; 

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int $user_id
 * @property int $school_id
 * @property int $rollno
 * @property int $regno
 * @property int $class_id
 * @property string $section
 * @property int $status
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    const USER_AVATAR_ID = "user_avatar_";
    const AVATAR = "avatar";

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

    public $password;
    public $addressCheck;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
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
            [['school_id', 'rollno', 'regno', 'name', 'class_id', 'section', 'gender', 'password'/*, 'email_selection', 'address_p', 'address_t',  'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t', 'password', 'status'*/], 'required'],
            ['email','email'],
            [['class_id','mobile','address_t', 'address_p', 'gender', 'blood_group'], 'string'],
            [['user_id', 'school_id', 'rollno', 'regno', 'status', 'created_by', 'updated_by', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t'], 'integer'],
            [['created_on', 'updated_on', 'section'], 'safe'],

            [['user_id', 'school_id', 'class_id'], 'unique', 'targetAttribute' => ['user_id', 'school_id', 'class_id'], 'message' => 'This student already exist in this class' ],


            [['rollno', 'school_id', 'class_id', 'section'], 'unique', 'targetAttribute' => ['rollno', 'school_id', 'class_id', 'section'], 'message' => 'Student with this roll number, class and section already in this system'],

            [['regno', 'school_id'], 'unique', 'targetAttribute' => ['regno', 'school_id'], 'message' => 'This resgistration number is already exist for this school'],


            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['school_id', 'rollno', 'regno', 'name', 'class_id', 'email_selection', 'address_p', 'address_t', 'gender', 'blood_group', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t', 'section','password','mobile','status'];
        $scenarios[self::SCENARIO_UPDATE] = ['school_id', 'rollno', 'regno', 'name', 'class_id', 'address_p', 'address_t', 'gender', 'blood_group', 'province_p', 'district_p', 'municipality_p', 'ward_p', 'province_t', 'district_t', 'municipality_t', 'ward_t', 'section','mobile','status'];
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
            'school_id' => Yii::t('app', 'School *'),
            'rollno' => Yii::t('app', 'Rollno *'),
            'regno' => Yii::t('app', 'Regno *'),
            'class_id' => Yii::t('app', 'Class *'),
            'section' => Yii::t('app', 'Section *'),
            'status' => Yii::t('app', 'School Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'name' => Yii::t('app', 'Name *'),
            'email' => Yii::t('app', 'Email *'),
            'mobile' => Yii::t('app', 'Mobile'),
            'blood_group' => Yii::t('app', 'Blood group'),
            'address_t' => Yii::t('app', 'Temporary Address'),
            'address_p' => Yii::t('app', 'Permanent Address'),
            'gender' => Yii::t('app', 'Gender *'),
            'province_p' => Yii::t('app', 'Province'),
            'district_p' => Yii::t('app', 'District'),
            'municipality_p' => Yii::t('app', 'Municipality'),
            'ward_p' => Yii::t('app', 'Ward'),
            'province_t' => Yii::t('app', 'Province1'),
            'district_t' => Yii::t('app', 'District'),
            'municipality_t' => Yii::t('app', 'Municipality'),
            'ward_t' => Yii::t('app', 'Ward'),
            'email_selection' => Yii::t('app', 'Email Selection *'),
            'addressCheck' => Yii::t('app', 'Use same address as permanent address'),
        ];
    }


    public function getSectionName()
    {
        return $this->section;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getName()
    {
        $content = $this->user; 
        if(isset($content))
        {
            return $content->profile->name;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['id' => 'school_id']);
    }

    public function getSchoolName()
    {
        $content = $this->school; 
        if(isset($content))
        {
            return $content->name;
        }
    }


    

    public function getCreatedOn()
    {
        $date = strtotime($this->created_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getUpdatedOn()
    {
        $date = strtotime($this->updated_on);
        return date("M d, Y H:i:s", $date);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCreatedByName()
    {
        $content = $this->createdBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->created_by) ? "You" : $content->email;
        }
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    public function getUpdatedByName()
    {
        $content = $this->updatedBy; 
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->updated_by) ? "You" : $content->email; 
        }
    }

    public function getAvatarIdentity()
    {
        return $this::USER_AVATAR_ID.$this->user_id;
    }

    function getAvatarFromMedia()
    {
        return Media::find()->where(['identity' => $this::USER_AVATAR_ID . $this->user_id]);

    }
 

    public function hasAvatar()
    {
        return $this->getAvatarFromMedia()->exists();
    } 

    public function getAvatar($backend = false,$remove=false)
    {
        $db = $this->getAvatarFromMedia();
        if ($db->exists()) {

            $db_avatar = $db->one();

            $image = json_decode($db_avatar->image);
            if($remove==true){
                Media::UNLINK_IMAGE($image[0]->file_path);
                $db_avatar->delete();
                return null;
            }
            if ($backend == true) {
                $link = [];
                $link['url'][] = $image[0]->url;
                $link['config'][] = ['size' => $image[0]->size, 'url' => Url::toRoute("/admin/media/remove-image?file=" . $image[0]->file_path . "&id=" . Encription::encryptIt($db_avatar->id) . "&type=" . Media::AVATAR)];
                $link['filePath'][] = $image[0]->file_path;

                return $link;
            } else {
                return $image[0]->url;
            }


        } else {
            return '/uploads/no-image.png';
        }

    } 
    
    public function beforeDelete()
    {
        $this->getAvatar(false,true);
        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\StudentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\StudentQuery(get_called_class());
    }
}
