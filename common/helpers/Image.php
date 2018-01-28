<?php

namespace common\helpers;

use Yii;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\UploadedFile;

/**
 * Class Image
 *
 * @package cms\helpers
 */
class Image
{
    /**
     * @param UploadedFile $fileInstance
     * @param string $dir
     * @param int|null $resizeWidth
     * @param int|null $resizeHeight
     * @param bool $resizeCrop
     * @return string
     * @throws HttpException
     */
    public static function upload(UploadedFile $fileInstance, $dir = '', $resizeWidth = null, $resizeHeight = null, $resizeCrop = false)
    {
        $fileName = Upload::getUploadPath($dir) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance);

        $uploaded = $resizeWidth
            ? static::copyResizedImage($fileInstance->tempName, $fileName, $resizeWidth, $resizeHeight, $resizeCrop)
            : $fileInstance->saveAs($fileName);

        if (!$uploaded) {
            throw new HttpException(500, 'Cannot upload file "' . $fileName . '". Please check write permissions.');
        }

        return Upload::getLink($fileName);
    }

    /**
     * @param $filename
     * @param int|null $width
     * @param int|null $height
     * @param bool $crop
     * @return string
     */
    static function thumb($filename, $width = null, $height = null, $crop = true)
    {
        if ($filename && is_file(($filename = Yii::getAlias('@webroot') . $filename))) {
            $info = pathinfo($filename);
            $thumbName = $info['filename'] . '-' . md5(filemtime($filename) . (int)$width . (int)$height . (int)$crop) . '.' . $info['extension'];
            $thumbFile = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . Upload::$UPLOADS_DIR . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $thumbName;
            $thumbWebFile = '/' . Upload::$UPLOADS_DIR . '/thumbs/' . $thumbName;
            if (file_exists($thumbFile)) {
                return $thumbWebFile;
            } elseif (FileHelper::createDirectory(dirname($thumbFile), 0777) && static::copyResizedImage($filename, $thumbFile, $width, $height, $crop)) {
                return $thumbWebFile;
            }
        }
        return '';
    }

    static function copyResizedImage($inputFile, $outputFile, $width, $height = null, $crop = true)
    {
        if (extension_loaded('gd')) {
            $image = new GD($inputFile);

            if ($height) {
                if ($width && $crop) {
                    $image->cropThumbnail($width, $height);
                } else {
                    $image->resize($width, $height);
                }
            } else {
                $image->resize($width);
            }
            return $image->save($outputFile);
        } elseif (extension_loaded('imagick')) {
            $image = new \Imagick($inputFile);

            if ($height && !$crop) {
                $image->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
            } else {
                $image->resizeImage($width, null, \Imagick::FILTER_LANCZOS, 1);
            }

            if ($height && $crop) {
                $image->cropThumbnailImage($width, $height);
            }

            return $image->writeImage($outputFile);
        } else {
            throw new HttpException(500, 'Please install GD or Imagick extension');
        }
    }
}