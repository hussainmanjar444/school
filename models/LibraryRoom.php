<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "library_room".
 *
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string $code
 * @property int $floor
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property InventoryLocation[] $inventoryLocations
 * @property School $school
 * @property LibraryRoomRack[] $libraryRoomRacks
 */
class LibraryRoom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'library_room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'name', 'code', 'floor'], 'required'],
            [['id', 'school_id','created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on', 'floor'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'school_id' => Yii::t('app', 'School *'),
            'name' => Yii::t('app', 'Name *'),
            'code' => Yii::t('app', 'Code *'),
            'floor' => Yii::t('app', 'Floor *   '),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
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
        return $this->hasMany(InventoryLocation::className(), ['room_id' => 'id']);
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
            return ucwords($content->name);
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
     * @return \yii\db\ActiveQuery
     */
    public function getLibraryRoomRacks()
    {
        return $this->hasMany(LibraryRoomRack::className(), ['room_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\LibraryRoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\LibraryRoomQuery(get_called_class());
    }
}
