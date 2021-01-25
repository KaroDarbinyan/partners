<?php

namespace common\models;

use Throwable;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news_links".
 *
 * @property int $id
 * @property int $news_id
 * @property string $dir_name
 * @property string $file_name
 * @property string $file_extension
 * @property string $file_original_name
 * @property string $file_size
 * @property string $file_desc
 */
class NewsLinks extends ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $file;

    public $path;

    private $file_types = [
        "jpeg" => ["image/jpeg", "image"],
        "png" => ["image/png", "image"],
        "jpg" => ["image/jpg", "image"],
        "pdf" => ["pdf", "pdf"],
        "rar" => ["rar", "rar"],
        "zip" => ["zip", "zip"]
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['dir_name', 'file_name', 'file_extension', 'file_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'dir_name' => 'Dir Name',
            'file_name' => 'File Name',
            'file_extension' => 'File Extension',
            'file_original_name' => 'File Original Name',
            'file_size' => 'File Size',
            'file_desc' => 'file_desc',
        ];
    }

    public function beforeSave($insert)
    {
        $this->file_extension = $this->file->extension;
        $this->file_original_name = $this->file->name;
        $this->file_size = $this->file->size;
        $this->file_name = sprintf("%s.%s", uniqid(time()), $this->file_extension);
        return parent::beforeSave($insert);
    }


    public function afterSave($insert, $changedAttributes)
    {

        $directory = $this->getDirectory();
        $str = "{$directory}{$this->file_name}";
        $this->file->saveAs($str);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool|false|int
     * @throws Throwable
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete()
    {
        $this->path = $this->getDirectory() . $this->file_name;
        if (file_exists($this->path))
            FileHelper::unlink($this->path);

        return parent::delete();
    }

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        $directory = Yii::getAlias('@frontend') . "/web/img/news/{$this->dir_name}/";
        if (!is_dir($directory)) {
            try {
                FileHelper::createDirectory($directory);
            } catch (Exception $e) {
            }
        }
        return $directory;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return Yii::$app->request->hostInfo . "/img/news/{$this->dir_name}/";

    }

    public function getType()
    {
        return $this->file_types[$this->file_extension][1];
    }


    public function getFileType()
    {
        return $this->file_types[$this->file_extension][0];
    }

}
