<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string $identity
 * @property string $image
 */
class Media extends \yii\db\ActiveRecord
{
    const AVATAR = "avatar";
    const ADDITIONAL_IMAGE = "additional_image";
    public $uploads;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['uploads', 'required'],
            [['uploads'], 'file', 'skipOnEmpty' => false, 'extensions' => ['jpg', 'png'], 'checkExtensionByMimeType' => false, 'maxSize' => 3024 * 3024 * 5, 'maxFiles' => 10],
            [['identity', 'image'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'identity' => Yii::t('app', 'Identity'),
            'image' => Yii::t('app', 'Image'),
        ];
    }


    public function UPLOAD($imageFiles, $oldImages = false)
    {


        if ($imageFiles) {
            //folder
            $directory = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR;

            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            if (is_array($imageFiles)) {
                $image = array();
                foreach ($imageFiles as &$imageFile) {

                    $uid = uniqid(time(), true);
                    $fileName = $uid . '.' . $imageFile->extension;
                    $filePath = $directory . $fileName;
                    if ($imageFile->saveAs($filePath)) {
                        $path = Yii::$app->request->getBaseUrl() . '/uploads' . $fileName;
                        $image[] = [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'extension' => $imageFile->extension,
                            'url' => $path,
                            'file_path' => $filePath,
                            'directory' => $directory,
                        ];

                    } else {
                        return false;
                    }
                }


            } else {

                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $imageFiles->extension;
                $filePath = $directory . $fileName;
                if ($imageFiles->saveAs($filePath)) {
                    $path = Yii::$app->request->getBaseUrl() . '/uploads/' . $fileName;

                    $image [] = [
                        'name' => $fileName,
                        'size' => $imageFiles->size,
                        'extension' => $imageFiles->extension,
                        'url' => $path,
                        'file_path' => $filePath,
                        'directory' => $directory,

                    ];


                } else {
                    return false;
                }
            }
            if ($oldImages) {
                $oldImages = json_decode($oldImages, true);
                if (is_array($oldImages)) {
                    $return = array_merge($oldImages, $image);
                } else {
                    $return = $image;
                }
            } else {
                $return = $image;
            }

            return json_encode($return);
        }
        return false;

    }
    public static function UNLINK_IMAGE($directory, $oldFiles = false)
    {

        if (is_file($directory)) {
            unlink($directory);
        }
        if ($oldFiles) {
            $oldFiles = json_decode($oldFiles, true);

            foreach ($oldFiles as $key => $value) {
                if (in_array($directory, $value)) {
                    unset($oldFiles[$key]);
                }
            }
            if (is_array($oldFiles)) {
                $count = count($oldFiles);
                if ($count <= 0) {
                    return null;
                }

            }
            return json_encode($oldFiles);

        }
        return null;


    }

    /**
     * @inheritdoc
     * @return \app\models\activeQuery\MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\activeQuery\MediaQuery(get_called_class());
    }
}
