<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "library_room_rack".
 *
 * @property int $id
 * @property int $room_id
 * @property string $name
 * @property string $code
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property InventoryLocation[] $inventoryLocations
 * @property LibraryRoom $room
 */
class LibraryRoomRack extends \yii\db\ActiveRecord
{
    const SCENARIO_ADD_RACK_FROM_SCHOOL = 'add_rack_from_school';
    const SCENARIO_UPDATE_RACK_FROM_SCHOOL = 'update_rack_from_school';
    public $school_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'library_room_rack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'room_id', 'name', 'code'], 'required'],
            [['room_id', 'created_by', 'updated_by', 'school_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => LibraryRoom::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios(); 

        $scenarios[self::SCENARIO_ADD_RACK_FROM_SCHOOL] = ['room_id', 'name', 'code']; 
        $scenarios[self::SCENARIO_UPDATE_RACK_FROM_SCHOOL] = ['name', 'code']; 

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'school_id' => Yii::t('app', 'School *'),
            'room_id' => Yii::t('app', 'Room *'),
            'name' => Yii::t('app', 'Name *'),
            'code' => Yii::t('app', 'Code *'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }


    public function beforeSave($text)
    {
        $this->updated_on = date("Y-m-d h:i:s");
        $this->updated_by = Yii::$app->user->identity->id;
        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($text);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryLocations()
    {
        return $this->hasMany(InventoryLocation::className(), ['rack_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(LibraryRoom::className(), ['id' => 'room_id']);
    }

    public function getRoomName()
    {
        $content = $this->room;
        if(isset($content))
        {
            return $content->name.' [ '.$content->code.' ]';
        }
    }

    public function getSchoolName()
    {
        $content = $this->room;
        if(isset($content))
        {
            return $content->schoolName;
        }
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(),['id' => 'created_by']);
    }

    public function getCreatedByName()
    {
        $content = $this->createdBy;
        if(isset($content))
        {
            return ($this->created_by == Yii::$app->user->identity->id) ? "You ( ".$content->email." )" : $content->email;
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
            return ($this->updated_by == Yii::$app->user->identity->id) ? "You ( ".$content->email." )" : $content->email;
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\LibraryRoomRackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\LibraryRoomRackQuery(get_called_class());
    }
}
