<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_issue".
 *
 * @property int $id
 * @property int $inventory_id
 * @property int $student_id
 * @property string $request_date 
 * @property string $issued_date
 * @property string $issue_tilldate
 * @property string $return_date
 * @property double $actual_fine
 * @property double $collected_fine
 * @property int $issue_by
 * @property int $recieved_by 
 * @property int $status
 *
 * @property Inventory $inventory
 * @property Student $student
 */
class InventoryIssue extends \yii\db\ActiveRecord
{
    const SCENARIO_BOOK_REQUEST = "book_request"; 
    const SCENARIO_BOOK_REQUEST_ISSUED = "book_request_issued";
    const SCENARIO_BOOK_REQUEST_ISSUED_ADMIN = "book_request_issued_admin";
    const SCENARIO_BOOK_RECEIVE = "book_received";
    const SCENARIO_NEW_BOOK_ISSUED = "new_book_issued"; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_id', 'student_id', 'issue_tilldate', 'collected_fine','issued_date', 'issue_by', 'status', 'return_date', 'recieved_by'], 'required'],
            [['inventory_id', 'student_id', 'issue_by', 'status'], 'integer'],
            [['issued_date', 'issue_tilldate', 'return_date', 'request_date'], 'safe'],
            [['actual_fine', 'collected_fine'], 'number'],
            [['inventory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventory::className(), 'targetAttribute' => ['inventory_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_BOOK_REQUEST_ISSUED] = ['issued_date', 'issue_tilldate', 'issue_by', 'status']; 
        $scenarios[self::SCENARIO_BOOK_RECEIVE] = ['return_date', 'recieved_by', 'status'];   

        $scenarios[self::SCENARIO_NEW_BOOK_ISSUED] = ['student_id', 'inventory_id', 'issued_date', 'issue_tilldate', 'issue_by', 'status'];  

        $scenarios[self::SCENARIO_BOOK_REQUEST] = ['student_id', 'inventory_id'];  
 

        return $scenarios;
    }
 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'inventory_id' => Yii::t('app', 'Books *'),
            'student_id' => Yii::t('app', 'Student'),
            'request_date ' => Yii::t('app', 'Requested Date'),
            'issued_date' => Yii::t('app', 'Issued Date'),
            'issue_tilldate' => Yii::t('app', 'Issue Tilldate'),
            'return_date' => Yii::t('app', 'Return Date'),
            'actual_fine' => Yii::t('app', 'Actual Fine'),
            'collected_fine' => Yii::t('app', 'Collected Fine'),
            'issue_by' => Yii::t('app', 'Issued By'),
            'recieved_by ' => Yii::t('app', 'Received By'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueBy()
    {
        return $this->hasOne(User::className(), ['id' => 'issue_by']);
    }

    public function getIssueByName()
    {
        $content = $this->issueBy;
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->issue_by) ? "You" : $content->username;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'recieved_by']);
    }
    public function getReceivedByName()
    {
        $content = $this->receivedBy;
        if(isset($content))
        {
            return (Yii::$app->user->identity->id == $this->recieved_by) ? "You" : $content->username;
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
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\InventoryIssueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\InventoryIssueQuery(get_called_class());
    }
}
