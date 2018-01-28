<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

class ImageUploadsBehavior extends Behavior
{
    /** @var  string */
    public $controller_id;

    /** @var  string */
    public $imageFieldName;

    public function actionImageUpload($model)
    {

        $file = UploadedFile::getInstance($model, $this->imageFieldName);

        if (!$file) {
            return $model->oldAttributes[$this->imageFieldName] ;
        }
        $filename = Inflector::slug(Yii::$app->getSecurity()->generateRandomString(20). $file->baseName) . '.' . $file->extension;

        $base_path = 'uploads/'.$this->controller_id.'/';

        $path = \Yii::getAlias('@webroot') . '/'.$base_path;

        FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

        if ($file->saveAs($path . $filename)) {
            return $base_path . $filename;
        }
    }
}