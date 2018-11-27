<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_location".
 *
 * @property int $id
 * @property int $inventory_id
 * @property int $room_id
 * @property int $rack_id
 * @property string $shelf_id
 * @property string $created_on
 * @property int $created_by
 * @property int $updated_on
 * @property int $updated_by
 *
 * @property Inventory $inventory
 * @property LibraryRoomRack $rack
 * @property LibraryRoom $room
 */
class InventoryLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_id', 'room_id', 'rack_id', 'shelf_id'], 'required'],
            [['inventory_id', 'room_id', 'rack_id', 'created_by', 'updated_on', 'updated_by'], 'integer'],
            [['shelf_id'], 'string'],
            [['created_on'], 'safe'], 
            [['inventory_id', 'room_id', 'rack_id', 'shelf_id'], 'unique', 'targetAttribute' => ['inventory_id', 'room_id', 'rack_id', 'shelf_id']],
            [['inventory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventory::className(), 'targetAttribute' => ['inventory_id' => 'id']],
            [['rack_id'], 'exist', 'skipOnError' => true, 'targetClass' => LibraryRoomRack::className(), 'targetAttribute' => ['rack_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => LibraryRoom::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'inventory_id' => Yii::t('app', 'Inventory ID'),
            'room_id' => Yii::t('app', 'Room *'),
            'rack_id' => Yii::t('app', 'Rack *'),
            'shelf_id' => Yii::t('app', 'Shelf *'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
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

    public function beforeSave($text)
    {
        $this->updated_by = Yii::$app->user->identity->profile->user_id;
        $this->updated_on = date("Y-m-d H:i:s");

        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->profile->user_id;  
        } 
        return parent::beforeSave($text);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRack()
    {
        return $this->hasOne(LibraryRoomRack::className(), ['id' => 'rack_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(LibraryRoom::className(), ['id' => 'room_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\InventoryLocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\InventoryLocationQuery(get_called_class());
    }
}
