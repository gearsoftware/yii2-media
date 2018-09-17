<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\assets;

use gearsoftware\assets\core\CoreAsset;
use yii\timeago\TimeAgoAsset;
use yii\web\AssetBundle;

class MediaAsset extends AssetBundle
{
    public $sourcePath = '@vendor/gearsoftware/yii2-media/src/assets/source';
    public $css = [
        'css/media.css',
    ];
    public $js = [
        'js/media.js',
    ];
    public $depends = [
    	CoreAsset::class,
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
