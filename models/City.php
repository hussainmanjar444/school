<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property int $province
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property Province $province0
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'province'], 'required'],
            [['province', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name', 'province'], 'unique', 'targetAttribute' => ['name', 'province']],
            [['province'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province' => 'id']],
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
            'province' => Yii::t('app', 'Province'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    public function beforeSave($text)
    {
        if($this->isNewRecord)
        {
            $this->created_by = Yii::$app->user->identity->id; 
            $this->updated_by = Yii::$app->user->identity->id; 
            $this->updated_on = date("Y-m-d H:i:s");
        }
        else
        {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_on = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($text);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince0()
    {
        return $this->hasOne(Province::className(), ['id' => 'province']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\CityQuery(get_called_class());
    }
}
