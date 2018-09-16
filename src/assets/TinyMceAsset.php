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

class TinyMceAsset extends AssetBundle
{

    public $sourcePath = '@vendor/tinymce/tinymce';
    public $js = [
        'tinymce.jquery.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
