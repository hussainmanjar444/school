<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_history".
 *
 * @property int $id
 * @property int $inventory_id
 * @property string $quantity
 * @property int $vendor_id
 * @property double $amount
 * @property string $comment
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property Inventory $inventory
 */
class InventoryHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_id', 'quantity', 'vendor_id'], 'required'],
            [['inventory_id', 'quantity', 'vendor_id', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['inventory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventory::className(), 'targetAttribute' => ['inventory_id' => 'id']],
        ];
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'inventory_id' => Yii::t('app', 'Inventory ID'),
            'quantity' => Yii::t('app', 'Quantity *'),
            'vendor_id' => Yii::t('app', 'Vendor *'),
            'amount' => Yii::t('app', 'Amount *'),
            'comment' => Yii::t('app', 'Comment'),
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
    public function getVendor()
    {
        return $this->hasOne(BookVendor::className(), ['id' => 'vendor_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\InventoryHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\InventoryHistoryQuery(get_called_class());
    }
}
