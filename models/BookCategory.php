<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $details
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 */
class BookCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['details'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    public function beforeSave($text)
    {

        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->profile->user_id;
            $this->updated_on = date("Y-m-d H:i:s");
            return parent::beforeSave($text);
        }
        else
        {
            $this->updated_by = Yii::$app->user->identity->profile->user_id;
            $this->updated_on = date("Y-m-d H:i:s");
            return parent::beforeSave($text);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'name' => Yii::t('app', 'Name *'),
            'details' => Yii::t('app', 'Details'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(BookCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(BookCategory::className(), ['parent_id' => 'id']);
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
     * @return \app\models\activeQuery\BookCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\BookCategoryQuery(get_called_class());
    }
}
