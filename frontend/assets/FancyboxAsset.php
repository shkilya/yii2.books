<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Class FancyboxAsset
 * @package frontend\assets
 */
class FancyboxAsset extends  AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.fancybox.min.js'
    ];
    public $css = [
        'css/jquery.fancybox.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];


}