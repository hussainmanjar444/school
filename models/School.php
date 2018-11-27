<?php

namespace app\models;

use Yii;
use app\helpers\Configuration;
use yii\helpers\Url;
use app\helpers\Encription; 

/**
 * This is the model class for table "school".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $code
 * @property string $address
 * @property int $province_id
 * @property int $district_id
 * @property int $municipality_id
 * @property string $ward_no
 * @property string $established_year
 * @property string $website
 * @property string $contactno
 * @property int $status
 * @property string $added_on
 * @property int $added_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property Inventory[] $inventories
 * @property LibraryRoom[] $libraryRooms
 * @property SchoolAdmin[] $schoolAdmins
 * @property User[] $users
 * @property SchoolLibrarian[] $schoolLibrarians
 * @property User[] $users0
 * @property SchoolTeacher[] $schoolTeachers
 * @property User[] $users1
 */
class School extends \yii\db\ActiveRecord
{

    const SCHOOL_ADDITIONAL_IMAGE = "school_additional_image_";
    const ADDITIONAL_IMAGE = "additional_image";
    const SCHOOL_AVATAR_ID = "school_avatar_";
    const AVATAR = "avatar";


    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $userId;
    public $password;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'address', 'province_id', 'district_id', 'municipality_id', 'ward_no', 'established_year', 'status', 'code'], 'required'],
            [['address'], 'string'],
            [['province_id', 'district_id', 'municipality_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['established_year', 'added_on', 'updated_on'], 'safe'],
            [['name', 'email', 'code', 'ward_no', 'website', 'contactno'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'email','password', 'address', 'province_id', 'district_id', 'municipality_id', 'ward_no', 'established_year', 'contactno', 'status', 'code', 'website', 'contactno'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'email', 'address', 'province_id', 'district_id', 'municipality_id', 'ward_no', 'established_year', 'contactno', 'status', 'code', 'website', 'contactno'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name *'),
            'email' => Yii::t('app', 'Email *'),
            'password' => Yii::t('app', 'Password *'),
            'code' => Yii::t('app', 'Code *'),
            'address' => Yii::t('app', 'Address *'),
            'province_id' => Yii::t('app', 'Province *'),
            'district_id' => Yii::t('app', 'District *'),
            'municipality_id' => Yii::t('app', 'Municipality *'),
            'ward_no' => Yii::t('app', 'Ward No *'),
            'established_year' => Yii::t('app', 'Established Year *'),
            'website' => Yii::t('app', 'Website'),
            'contactno' => Yii::t('app', 'Contactno'),
            'status' => Yii::t('app', 'Status *'),
            'added_on' => Yii::t('app', 'Added On'),
            'added_by' => Yii::t('app', 'Added By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }


    public function beforeSave($text)
    {
        $this->updated_by = Yii::$app->user->identity->id; 
        $this->updated_on = date("Y-m-d H:i:s");
        if($this->isNewRecord)
        {
            $this->added_by = Yii::$app->user->identity->id; 
        } 
        return parent::beforeSave($text);
    }

     public function getAddedBy()
    {
        return $this->hasOne(User::className(),['id' => 'added_by']);
    }

    public function getAddedByName()
    {
        $content = $this->addedBy;
        if(isset($content))
        {
            return ($this->added_by == Yii::$app->user->identity->id) ? "You ".' ( '.$content->email.' )' : $content->email;
        }
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(),['id' => 'updated_by']);
    }

    public function getUpdatedByName()
    {
        $content = $this->updatedBy;
        if(isset($content))
        {
            return ($this->updated_by == Yii::$app->user->identity->id) ? "You ".' ( '.$content->email.' )' : $content->email;
        }
    }

    public function getWardNo()
    {
        return "Ward No ".$this->ward_no;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibraryRooms()
    {
        return $this->hasMany(LibraryRoom::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolAdmins()
    {
        return $this->hasMany(SchoolAdmin::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('school_admin', ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolLibrarians()
    {
        return $this->hasMany(SchoolLibrarian::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('school_librarian', ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolTeachers()
    {
        return $this->hasMany(SchoolTeacher::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers1()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('school_teacher', ['school_id' => 'id']);
    }


    public function getAvatarIdentity()
    {
        return $this::SCHOOL_AVATAR_ID.$this->id;
    }

    function getAvatarFromMedia()
    {
        return Media::find()->where(['identity' => $this::SCHOOL_AVATAR_ID . $this->id]);

    }

    function getImagesFromMedia()
    {
        return Media::find()->where(['identity' => $this::SCHOOL_ADDITIONAL_IMAGE . $this->id]);

    }

    public function hasAvatar()
    {
        return $this->getAvatarFromMedia()->exists();
    }
    
    public function hasImages()
    {
        return $this->getImagesFromMedia()->exists();
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
    public function getImages($backend = false, $remove = false)
    {
        $db = $this->getImagesFromMedia();
        if ($db->exists()) {

            $db_image = $db->one();

            $images = json_decode($db_image->image);
            $link = [];
            foreach ($images as $image) {
                if ($remove == true) {
                    Media::UNLINK_IMAGE($image->file_path);
                    /*   $db_image->delete();
                       return null;*/
                }
                $link['url'][] = $image->url;
                $link['config'][] = ['size' => $image->size, 'url' => Url::toRoute("/admin/media/remove-image?file=" . $image->file_path . "&id=" . Encription::encryptIt($db_image->id) . "&type=" . Media::ADDITIONAL_IMAGE)];
                $link['filePath'][] = $image->file_path;
            }

            if($remove==true){
                return $db_image->delete();
            }
            if ($backend = true) {
                return $link;

            } else {
                return $link['url'];
            }


        } else {
            return null;
        }
    }
    
    public function beforeDelete()
    {
        $this->getAvatar(false,true);
        return parent::beforeDelete();
    }


    /**
     * {@inheritdoc}
     * @return SchoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SchoolQuery(get_called_class());
    }
}
