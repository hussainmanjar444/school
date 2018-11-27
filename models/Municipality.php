<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipality".
 *
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property int $district_id
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property Province $province
 * @property District $district
 */
class Municipality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'province_id', 'district_id'], 'required'],
            [['province_id', 'district_id', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name', 'province_id', 'district_id'], 'unique', 'targetAttribute' => ['name', 'district_id', 'province_id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
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
            'name' => Yii::t('app', 'Name *'),
            'province_id' => Yii::t('app', 'Province *'),
            'district_id' => Yii::t('app', 'District *'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\MunicipalityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\MunicipalityQuery(get_called_class());
    }
}
