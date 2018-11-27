<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_publisher".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $contactno
 * @property string $address
 * @property string $details
 * @property string $website
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 */
class BookPublisher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_publisher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['details'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'email', 'contactno', 'address', 'website'], 'string', 'max' => 255], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name  *'),
            'email' => Yii::t('app', 'Email'),
            'contactno' => Yii::t('app', 'Contact no'),
            'address' => Yii::t('app', 'Address'),
            'details' => Yii::t('app', 'Details'),
            'website' => Yii::t('app', 'Website'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
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

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    public function getCreatedByName()
    {
        $content = $this->createdBy; 
        if(isset($content)) {
            return (Yii::$app->user->identity->id == $this->created_by) ? "You" : $content->username;
        }  
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    public function getUpdatedByName()
    {
        
        $content = $this->updatedBy; 
        if(isset($content)) {
            return (Yii::$app->user->identity->id == $this->updated_by) ? "You" : $content->username;
        }    
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\BookPublisherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\BookPublisherQuery(get_called_class());
    }
}
