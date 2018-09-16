<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel gearsoftware\media\models\Media */

$this->title = Yii::t('core/media', 'Upload New File');

if ($mode !== 'modal') {
    $this->params['breadcrumbs'][] = $this->title;
}
?>

<div <?= ($mode == 'normal') ? 'class="panel"' : '' ?>>
    <div <?= ($mode == 'normal') ? 'class="panel-body"' : '' ?>>
        <div id="uploadmanager">
            <p>
                <?= Html::a('← ' . Yii::t('core/media', 'Back to file manager'), ($mode == 'modal') ? ['manage/index', 'mode' => 'modal'] : ['default/index', 'mode' => 'normal'], ['class' => 'link']) ?>
            </p>

            <?= FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'file',
                'formView' => '@vendor/gearsoftware/yii2-media/views/upload-widget/form',
                'uploadTemplateView' => '@vendor/gearsoftware/yii2-media/views/upload-widget/upload',
                'downloadTemplateView' => '@vendor/gearsoftware/yii2-media/views/upload-widget/download',
                'clientOptions' => [
                    'autoUpload' => Yii::$app->getModule('media')->autoUpload,
                ],
                'url' => ['upload'],
                'gallery' => false,
            ]) ?>

        </div>
    </div>
</div>