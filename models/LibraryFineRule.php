<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "library_fine_rule".
 *
 * @property int $id
 * @property int $school_id
 * @property int $name
 * @property int $details
 * @property int $amount
 * @property string $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property School $school
 */
class LibraryFineRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'library_fine_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'name', 'amount'], 'required'],
            [[ 'name', 'details'], 'string'],
            [['school_id', 'amount', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
        ];
    }


    public function beforeSave($text)
    {
        $this->updated_on = date('Y-m-d H:i:s');
        $this->updated_by = Yii::$app->user->identity->id;
        if($this->isNewRecord)
        {
            $this->updated_by = Yii::$app->user->identity->id;
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
            'school_id' => Yii::t('app', 'School *'),
            'name' => Yii::t('app', 'Name *'),
            'details' => Yii::t('app', 'Details'),
            'amount' => Yii::t('app', 'Amount *'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
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

    public function getAmount()
    {
        return 'NPR '.$this->amount;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['id' => 'school_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\LibraryFineRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\LibraryFineRuleQuery(get_called_class());
    }
}
