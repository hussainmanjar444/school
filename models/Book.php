<?php

namespace app\models;

use Yii; 
use app\helpers\Configuration;
use yii\helpers\Url;
use app\helpers\Encription; 

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $isbn
 * @property string $name
 * @property string $details
 * @property int $edition
 * @property int $author_id
 * @property int $publisher_id
 * @property int $category_id 
 * @property string $published_year
 * @property string $comment
 * @property string $language
 * @property string $book_type
 * @property int $status
 * @property int $created_by
 * @property string $created_on
 * @property int $updated_by
 * @property string $updated_on
 *
 * @property BookAuthor $author
 * @property BookPublisher $publisher
 * @property BookCategory $category
 */
class Book extends \yii\db\ActiveRecord
{
    const BOOK_ADDITIONAL_IMAGE = "book_additional_image_";
    const ADDITIONAL_IMAGE = "additional_image";
    const BOOK_AVATAR_ID = "book_avatar_";
    const AVATAR = "avatar";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn', 'name', 'edition', 'author_id', 'publisher_id', 'category_id', 'book_type', 'language'], 'required'],
            [['details', 'comment'], 'string'],
            [['edition', 'author_id', 'publisher_id', 'category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['isbn', 'name','published_year','book_type', 'language'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookAuthor::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookPublisher::className(), 'targetAttribute' => ['publisher_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'isbn' => Yii::t('app', 'Isbn *'),
            'name' => Yii::t('app', 'Name *'),
            'details' => Yii::t('app', 'Details'),
            'edition' => Yii::t('app', 'Edition *'), 
            'published_year' => Yii::t('app', 'Published year *'), 
            'comment' => Yii::t('app', 'Comment'),
            'book_type' => Yii::t('app', 'Book type *'),
            'language' => Yii::t('app', 'Language *'),
            'author_id' => Yii::t('app', 'Author *'),
            'publisher_id' => Yii::t('app', 'Publisher *'),
            'category_id' => Yii::t('app', 'Category *'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(BookAuthor::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(BookPublisher::className(), ['id' => 'publisher_id']);
    }

    public function getSelectBook()
    {
        return $this->isbn. ' - '.$this->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BookCategory::className(), ['id' => 'category_id']);
    }
    public function getAvatarIdentity()
    {
        return $this::BOOK_AVATAR_ID.$this->id;
    }

    function getAvatarFromMedia()
    {
        return Media::find()->where(['identity' => $this::BOOK_AVATAR_ID . $this->id]);

    }

    function getImagesFromMedia()
    {
        return Media::find()->where(['identity' => $this::BOOK_ADDITIONAL_IMAGE . $this->id]);

    }

    public function hasAvatar()
    {
        return $this->getAvatarFromMedia()->exists();
    }
    
    public function hasImages()
    {
        return $this->getImagesFromMedia()->exists();
    }

    public function getAvatar($backend = false,$remove=false)
    {
        $db = $this->getAvatarFromMedia();
        if ($db->exists()) {

            $db_avatar = $db->one();

            $image = json_decode($db_avatar->image);
            if($remove==true){
                Media::UNLINK_IMAGE($image[0]->file_path);
                $db_avatar->delete();
                return null;
            }
            if ($backend == true) {
                $link = [];
                $link['url'][] = $image[0]->url;
                $link['config'][] = ['size' => $image[0]->size, 'url' => Url::toRoute("/admin/media/remove-image?file=" . $image[0]->file_path . "&id=" . Encription::encryptIt($db_avatar->id) . "&type=" . Media::AVATAR)];
                $link['filePath'][] = $image[0]->file_path;

                return $link;
            } else {
                return $image[0]->url;
            }


        } else {
            return '/uploads/no-image.png';
        }

    }
    public function getImages($backend = false, $remove = false)
    {
        $db = $this->getImagesFromMedia();
        if ($db->exists()) {

            $db_image = $db->one();

            $images = json_decode($db_image->image);
            $link = [];
            foreach ($images as $image) {
                if ($remove == true) {
                    Media::UNLINK_IMAGE($image->file_path);
                    /*   $db_image->delete();
                       return null;*/
                }
                $link['url'][] = $image->url;
                $link['config'][] = ['size' => $image->size, 'url' => Url::toRoute("/admin/media/remove-image?file=" . $image->file_path . "&id=" . Encription::encryptIt($db_image->id) . "&type=" . Media::ADDITIONAL_IMAGE)];
                $link['filePath'][] = $image->file_path;
            }

            if($remove==true){
                return $db_image->delete();
            }
            if ($backend = true) {
                return $link;

            } else {
                return $link['url'];
            }


        } else {
            return null;
        }
    }
    
    public function beforeDelete()
    {
        $this->getAvatar(false,true);
        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     * @return \app\models\activeQuery\BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\BookQuery(get_called_class());
    }
}
