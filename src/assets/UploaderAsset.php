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

use yii\web\AssetBundle;

class UploaderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/gearsoftware/yii2-media/assets/source';
    public $css = [
        'css/uploader.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
