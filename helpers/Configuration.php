<?php
namespace app\helpers; 

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "configuration".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $can_update_value
 */
class Configuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'can_update_value'], 'required'],
            [['value'], 'string'],
            [['can_update_value'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'can_update_value' => Yii::t('app', 'Can Update Value'),
        ];
    }



    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\ConfigurationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\ConfigurationQuery(get_called_class());
    }


    const SYSTEM_NAME = 'System';
    
    const ACTIVE = 1;
    const INACTIVE = 2;


    const YES = 3;
    const NO = 4;

    const PENDING = 5;
    const ISSUED = 6;
    const RETURNED = 7;

    const LIBRARY_MAX_ISSUE_TILL_DAYS = 7;

    const USER_ROLE_ADMIN = "admin";
    const USER_ROLE_DEVELOPER = "developer";
    const USER_ROLE_STUDENT = "student";
    const USER_ROLE_SCHOOL = "school";
    const USER_ROLE_LIBRARIAN = "librarian";
    const USER_ROLE_TEACHER = "teacher";
    const USER_ROLE_PARENT = "parent";
    const EMAIL_EXTENSION = "@campuskit.org";


    const FEATURE_ARRAY = [
        self::YES => "Yes",
        self::NO => "No"
    ];


    const STATUS_ARRAY = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    const LIBRARY_STATUS_ARRAY = [
        self::PENDING => 'Pending',
        self::ISSUED => 'Issued',
        self::RETURNED => 'Returned',
    ];

    const GET_SKINS_ARRAY = [
        'skin-blue' => 'skin-blue',
        'skin-black' => 'skin-black',
        'skin-red' => 'skin-red',
        'skin-yellow' => 'skin-yellow',
        'skin-purple' => 'skin-purple',
        'skin-green' => 'skin-green',
        'skin-blue-light' => 'skin-blue-light',
        'skin-black-light' => 'skin-black-light',
        'skin-red-light' => 'skin-red-light',
        'skin-yellow-light' => 'skin-yellow-light',
        'skin-purple-light' => 'skin-purple-light',
        'skin-green-light' => 'skin-green-light'

    ];

    const GET_CLASS_ARRAY = [
        'Nursery' => 'Nursery',
        'L.K.G' => 'L.K.G',
        'U.K.G' => 'U.K.G',
        'I' => 'I',
        'II' => 'II',
        'III' => 'III',
        'IV' => 'IV',
        'V' => 'V',
        'VI' => 'VI',
        'VII' => 'VII',
        'VIII' => 'VIII',
        'IX' => 'IX',
        'X' => 'X',
        'XI' => 'XI',
        'XII' => 'XII',

    ];

    const GET_WARDS_ARRAY = [
        '1' => 'Ward No 1', 
        '2' => 'Ward No 2', 
        '3' => 'Ward No 3', 
        '4' => 'Ward No 4', 
        '5' => 'Ward No 5', 
        '6' => 'Ward No 6', 
        '7' => 'Ward No 7', 
        '8' => 'Ward No 8', 
        '9' => 'Ward No 9',  
    ];

    const GET_SHELF_ARRAY = [
        'Shelf1' => 'Shelf1', 
        'Shelf2' => 'Shelf2', 
        'Shelf3' => 'Shelf3', 
        'Shelf4' => 'Shelf4', 
        'Shelf5' => 'Shelf5', 
        'Shelf6' => 'Shelf6', 
        'Shelf7' => 'Shelf7', 
        'Shelf8' => 'Shelf8', 
        'Shelf9' => 'Shelf9',  
        'Shelf10' => 'Shelf10',  
        'Shelf11' => 'Shelf11',  
        'Shelf12' => 'Shelf12',  
        'Shelf13' => 'Shelf13',  
        'Shelf14' => 'Shelf14',  
        'Shelf15' => 'Shelf15',  
    ];

    const GET_SECTION_ARRAY = [
        'A' => 'A', 
        'B' => 'B', 
        'C' => 'C', 
        'D' => 'D',    
        'E' => 'E',    
        'F' => 'F',     
        'G' => 'G',     
    ];

    const GET_BOOK_TYPE_ARRAY = [
        'Reference book' => 'Reference book',      
        'Academic book' => 'Academic book',      
    ];

    const GET_BOOK_LANGUAGE_ARRAY = [
        'English' => 'English',      
        'Nepali' => 'Nepali',      
        'Hindi' => 'Hindi',      
    ];
 
    const GET_FLOOR_ARRAY = [
        '1st floor' => '1st floor', 
        '2nd floor' => '2nd floor', 
        '3rd floor' => '3rd floor', 
        '4th floor' => '4th floor',    
        '5th floor' => '5th floor',    
        '6th floor' => '6th floor',    
        '7th floor' => '7th floor',    
        '8th floor' => '8th floor',    
        '9th floor' => '9th floor',    
    ];
 
    
    const DEFAULT_SKIN = "default_skin";

    public static function getDefaultSkin()
    {
        return self::getSitedata('default_skin');
    }

    public static function getStatus($value)
    {
        switch ($value) {
            case self::ACTIVE:  return self::STATUS_ARRAY[self::ACTIVE];
            case self::INACTIVE : return self::STATUS_ARRAY[self::INACTIVE]; 
            case self::PENDING : return self::LIBRARY_STATUS_ARRAY[self::PENDING]; 
            case self::ISSUED : return self::LIBRARY_STATUS_ARRAY[self::ISSUED]; 
            case self::RETURNED : return self::LIBRARY_STATUS_ARRAY[self::RETURNED];
            case self::YES: return "Yes";
            case self::NO:  return "No";
        }
    }

     /**
     * @param $name
     * @param bool $boolenOnly
     * @return bool|mixed|null
     */
    public static function getSitedata($name, $boolenOnly = false)
    { 
          if ($name != null) {

          //  $config = self::find()->where(['name' => $name])->one();
            $config = Yii::$app->setting->getConfig();

            if (!is_null($config)) {

                $name = ArrayHelper::getValue($config,$name,'N/A');

                //check if it is  boolen value

                if ($boolenOnly) {
                    if($name == "N/A"){
                        return false;
                    }

                    $checkTrue = ['1', 'true', 'TRUE', 'True', 'one', 'One', 'ONE'];
                    $checkFalse = ['0', 'false', 'FALSE', 'False', 'zero', 'ZERO', 'Zero'];
                    if (in_array($name['value'], $checkTrue, true)) {
                        return true;
                    } elseif (in_array($name['value'], $checkFalse, true)) {
                        return false;
                    } else {
                        return false;
                    }
                }

                if($name == "N/A"){
                    return $name;
                }
                return $name['value'];

            } else {
                return null;
            }


        } else {
            return false;
        }

    }
    public static function updateSiteData($name, $value)
    {
        $configData=self::find()->where(['name' => $name])->one();
        if(!is_null($configData)){
            if($configData->can_update_value==1){
                $configData->value = $value;
                return $configData->save(false);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
 
?>