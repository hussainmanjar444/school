<?php

namespace app\models;

use dektrium\user\models\Profile as BaseUser;
use Yii;
use app\helpers\Configuration;
use yii\helpers\Url;
use app\helpers\Encription; 

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
class Profile extends BaseUser
{   
    const USER_AVATAR_ID = "user_avatar_";
    const AVATAR = "avatar";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();  
        $rules[] = ['mobile', 'string', 'max' => 255];
        $rules[] = ['gender', 'string', 'max' => 255];
        $rules[] = ['blood_group', 'string', 'max' => 255];
        $rules[] = ['address_p', 'string', 'max' => 255];
        $rules[] = ['province_p', 'integer', 'max' => 255];
        $rules[] = ['district_p', 'integer', 'max' => 255];
        $rules[] = ['municipality_p', 'integer', 'max' => 255];
        $rules[] = ['ward_p', 'integer', 'max' => 255];
        $rules[] = ['address_t', 'string', 'max' => 255];
        $rules[] = ['province_t', 'integer', 'max' => 255];
        $rules[] = ['district_t', 'integer', 'max' => 255];
        $rules[] = ['municipality_t', 'integer', 'max' => 255];
        $rules[] = ['ward_t', 'integer', 'max' => 255];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels(); 
        $labels['mobile'] = Yii::t('app', 'Mobile');
        $labels['blood_group'] = Yii::t('app', 'Blood group');
        $labels['address_t'] = Yii::t('app', 'Temporary Address *');
        $labels['address_p'] = Yii::t('app', 'Permanent Address *');
        $labels['gender'] = Yii::t('app', 'Gender *');
        $labels['province_p'] = Yii::t('app', 'Province *');
        $labels['district_p'] = Yii::t('app', 'District *');
        $labels['municipality_p'] = Yii::t('app', 'Municipality *');
        $labels['ward_p'] = Yii::t('app', 'Ward *');
        $labels['province_t'] = Yii::t('app', 'Province1 *');
        $labels['district_t'] = Yii::t('app', 'District *');
        $labels['municipality_t'] = Yii::t('app', 'Municipality *');
        $labels['ward_t'] = Yii::t('app', 'Ward *');
        return $labels;
    } 


    public function getProvincePermanent()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_p']);
    }

    public function getProvincePermanentName()
    {
        $content = $this->provincePermanent;
        if($content)
        {
            return $content->name;
        }
    }
    public function getDistrictPermanent()
    {
        return $this->hasOne(District::className(), ['id' => 'district_p']);
    }

    public function getDistrictPermanentName()
    {
        $content = $this->districtPermanent;
        if($content)
        {
            return $content->name;
        }
    }
    public function getMunicipalityPermanent()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_p']);
    }

    public function getMunicipalityPermanentName()
    {
        $content = $this->municipalityPermanent;
        if($content)
        {
            return $content->name;
        }
    } 


    public function getwardPermanent()
    {
        return 'Ward '.$this->ward_p;
    }

    public function getProvinceTemporary()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_p']);
    }

    public function getProvinceTemporaryName()
    {
        $content = $this->provinceTemporary;
        if($content)
        {
            return $content->name;
        }
    }
    public function getDistrictTemporary()
    {
        return $this->hasOne(District::className(), ['id' => 'district_p']);
    }

    public function getDistrictTemporaryName()
    {
        $content = $this->districtTemporary;
        if($content)
        {
            return $content->name;
        }
    }
    public function getMunicipalityTemporary()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_p']);
    }

    public function getMunicipalityTemporaryName()
    {
        $content = $this->municipalityTemporary;
        if($content)
        {
            return $content->name;
        }
    } 


    public function getwardTemporary()
    {
        return 'Ward '.$this->ward_p;
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

    public function getMemeberSince()
    {
       $data = $this->user->created_at;
       return date("d M Y",$data);
    }
 
}
