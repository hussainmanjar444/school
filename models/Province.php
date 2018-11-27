<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $id
 * @property int $name
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            ['name','string'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'unique'],
        ];
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
            'name' => Yii::t('app', 'Name'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Last Updated By'),
            'updated_on' => Yii::t('app', 'Last Updated On'),
        ];
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
            return ($this->created_by == Yii::$app->user->identity->id) ? "You ".' ( '.$content->email.' )' : $content->email;
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

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\ProvinceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\ProvinceQuery(get_called_class());
    }
}
