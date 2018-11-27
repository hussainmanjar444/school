<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property int $id
 * @property int $book_id
 * @property int $school_id
 * @property string $quantity
 * @property string $avaliable_quantity
 * @property int $status
 * @property int $created_on
 * @property int $created_by
 * @property string $updated_on
 * @property int $updated_by
 *
 * @property Book $book
 * @property School $school
 * @property InventoryHistory[] $inventoryHistories
 * @property InventoryIssue[] $inventoryIssues
 * @property InventoryLocation[] $inventoryLocations
 */
class Inventory extends \yii\db\ActiveRecord
{ 
 
    const SCENARIO_EXISTING_BOOK_INVENTORY = 'existing_book_inventory'; 
    const SCENARIO_NEW_BOOK_INVENTORY = 'new_book_inventory'; 
    const SCENARIO_UPDATE_EXISTING = 'update_existing'; 
    const SCENARIO_UPDATE = 'update'; 
    const SCENARIO_BOOK_SEARCH = 'book_search'; 


    public $vendor_id;
    public $amount;
    public $comment;


    public $name;
    public $category_id;
    public $author_id;
    public $publisher_id;
    public $details;
    public $edition;
    public $published_year;
    public $book_type;
    public $language;
    public $keyword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'quantity', 'status', 'vendor_id', 'amount', 'name', 'category_id', 'author_id', 'publisher_id', 'edition', 'book_type', 'keyword', 'language'], 'required'],
            [['book_id', 'school_id', 'quantity', 'avaliable_quantity', 'status', 'created_on', 'created_by', 'updated_by'], 'integer'],
            [['updated_on', 'comment', 'details', 'published_year', 'book_type', 'keyword', 'language'], 'safe'],
            [['book_id', 'school_id'], 'unique', 'targetAttribute' => ['book_id', 'school_id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'id']],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_NEW_BOOK_INVENTORY] = ['book_id', 'school_id', 'quantity', 'status', 'vendor_id', 'amount', 'comment', 'name', 'category_id', 'author_id', 'publisher_id', 'edition', 'details', 'published_year', 'book_type', 'language']; 

        $scenarios[self::SCENARIO_EXISTING_BOOK_INVENTORY] = ['book_id', 'school_id', 'quantity', 'status', 'vendor_id', 'amount', 'comment', 'language']; 

        $scenarios[self::SCENARIO_UPDATE_EXISTING] = ['book_id', 'school_id', 'quantity', 'status'];

        $scenarios[self::SCENARIO_UPDATE] = ['quantity', 'avaliable_quantity', 'status']; 

        $scenarios[self::SCENARIO_BOOK_SEARCH] = ['keyword']; 

        return $scenarios;
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
            'book_id' => Yii::t('app', 'Book'),
            'school_id' => Yii::t('app', 'School *'),
            'quantity' => Yii::t('app', 'Quantity *'),
            'avaliable_quantity' => Yii::t('app', 'Avaliable Quantity'),
            'status' => Yii::t('app', 'Status *'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'amount' => Yii::t('app', 'Ammount *'),
            'name' => Yii::t('app', 'Name *'),
            'details' => Yii::t('app', 'Details'),
            'edition' => Yii::t('app', 'Edition *'), 
            'author_id' => Yii::t('app', 'Author *'),
            'publisher_id' => Yii::t('app', 'Publisher *'),
            'category_id' => Yii::t('app', 'Category *'),
            'vendor_id' => Yii::t('app', 'Vendor *'),
            'published_year' => Yii::t('app', 'Published Year'),
            'book_type' => Yii::t('app', 'Book Type *'),
            'language' => Yii::t('app', 'Language *'),
            'keyword' => Yii::t('app', 'Search keyword'),
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
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }


    public function getBookDetails()
    {
        $content = $this->book;
        if(isset($content))
        {
            return $content->isbn. ' - '.$content->name.' [ Total '.$this->avaliable_quantity.' books avaliable]';
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
    public function getInventoryHistories()
    {
        return $this->hasMany(InventoryHistory::className(), ['inventory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryIssues()
    {
        return $this->hasMany(InventoryIssue::className(), ['inventory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryLocations()
    {
        return $this->hasMany(InventoryLocation::className(), ['inventory_id' => 'id']);
    }


    public function AddBook($isbn)
    {
        $model = new \app\models\Book();
        $model->isbn = $isbn;
        $model->name = $this->name;
        $model->details = $this->details;
        $model->edition = $this->edition;
        $model->author_id = $this->author_id;
        $model->publisher_id = $this->publisher_id;
        $model->category_id = $this->category_id;
        $model->published_year = $this->published_year;
        $model->book_type = $this->book_type;
        $model->comment = $this->comment;
        $model->status = $this->status; 
        if($model->save(false))
        {
            return $model->id;
        }
        return false;

    }

    /**
     * {@inheritdoc}
     * @return InventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\InventoryQuery(get_called_class());
    }
}
