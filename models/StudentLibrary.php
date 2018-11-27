<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_library".
 *
 * @property int $id
 * @property int $school_id
 * @property int $student_id
 * @property string $card_no
 * @property int $card_limit
 * @property int $status
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property School $school
 * @property Student $student
 */
class StudentLibrary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_library';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'student_id', 'card_no', 'card_limit', 'status'], 'required'],
            [['school_id', 'student_id', 'card_limit', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['card_no'], 'string', 'max' => 255],
            [['school_id', 'student_id'], 'unique', 'targetAttribute' => ['school_id', 'student_id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'school_id' => Yii::t('app', 'School ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'card_no' => Yii::t('app', 'Card No'),
            'card_limit' => Yii::t('app', 'Card Limit'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated'),
            'updated_by' => Yii::t('app', 'Updated by'),
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
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * {@inheritdoc}
     * @return StudentLibraryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\StudentLibraryQuery(get_called_class());
    }
}
