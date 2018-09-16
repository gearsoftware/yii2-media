<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\assets\language\LanguagePillsAsset;
use gearsoftware\media\assets\MediaAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */

LanguagePillsAsset::register($this);
MediaAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            body {
                overflow-x: hidden;
            }
        </style>
    </head>
    <body style="background-color: #ecf0f5;">
        <div class="panel" style="margin-bottom: 0; min-height: 497px;">
            <div class="panel-body" style="padding: 15px 20px 15px;">
	            <?php $this->beginBody() ?>

	            <?= $content ?>

	            <?php $this->endBody() ?>
            </div>
        </div>
    </body>
    </html>
<?php $this->endPage();