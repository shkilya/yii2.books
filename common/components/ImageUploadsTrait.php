<?php

namespace commo\components;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * Trait ImageUploadTrait
 * @package frontend\modules\admin\components
 */
trait ImageUploadTrait
{
    protected function actionUpload($model)
    {

        $file = UploadedFile::getInstance($model, 'image');

        if (!$file) {
            return $model->oldAttributes['image'] ;
        }
        $filename = Inflector::slug(Yii::$app->getSecurity()->generateRandomString(20). $file->baseName) . '.' . $file->extension;

        $base_path = 'uploads/'.$this->id.'/';

        $path = \Yii::getAlias('@webroot') . '/'.$base_path;

        FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

        if ($file->saveAs($path . $filename)) {
            return $base_path . $filename;
        }
    }
}