<?php

namespace common\helpers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\HttpException;
use yii\web\UploadedFile;

/**
 * Class Upload
 *
 * @package cms\helpers
 */
class Upload
{
    /**
     * @var string
     */
    public static $UPLOADS_DIR = 'uploads';

    /**
     * @param UploadedFile $fileInstance
     * @param string $dir
     * @param bool $namePostfix
     * @return string
     * @throws HttpException
     */
    public static function file(UploadedFile $fileInstance, $dir = '', $namePostfix = true)
    {
        $fileName = Upload::getUploadPath($dir) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance, $namePostfix);

        if (!$fileInstance->saveAs($fileName)) {
            throw new HttpException(500, 'Cannot upload file "' . $fileName . '". Please check write permissions.');
        }
        return Upload::getLink($fileName);
    }

    /**
     * @param string $dir
     * @return string
     * @throws HttpException
     */
    static function getUploadPath($dir)
    {
        $uploadPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . static::$UPLOADS_DIR . ($dir ? DIRECTORY_SEPARATOR . $dir : '');
        if (!FileHelper::createDirectory($uploadPath)) {
            throw new HttpException(500, 'Cannot create "' . $uploadPath . '". Please check write permissions.');
        }
        return $uploadPath;
    }

    /**
     * @param string $fileName
     * @return string
     */
    static function getLink($fileName)
    {
        return str_replace('\\', '/', str_replace(Yii::getAlias('@webroot'), '', $fileName));
    }

    /**
     * @param UploadedFile $fileInstanse
     * @param bool $namePostfix
     * @return string
     */
    static function getFileName(UploadedFile $fileInstanse, $namePostfix = true)
    {
        $baseName = str_ireplace('.' . $fileInstanse->extension, '', $fileInstanse->name);
        $fileName = StringHelper::truncate(Inflector::slug($baseName), 32, '');
        if ($namePostfix || !$fileName) {
            $fileName .= ($fileName ? '-' : '') . substr(uniqid(md5(rand()), true), 0, 10);
        }
        $fileName .= '.' . $fileInstanse->extension;

        return $fileName;
    }
}