<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

/* @var $this yii\web\View */
/* @var $media \gearsoftware\media\models\Media */

use gearsoftware\comments\widgets\Comments;
use gearsoftware\helpers\CoreHelper;
use gearsoftware\media\assets\MediaAsset;
use gearsoftware\media\models\Media;
use gearsoftware\widgets\PdfViewer;
use gearsoftware\widgets\TimeAgo;
use yii\helpers\Html;

MediaAsset::register($this);

$this->title = ($media->title) ? $media->title :  Yii::t('core', '(not set)');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Media'), 'url' => ['/media']];
if($media->album){
	$this->params['breadcrumbs'][] = ['label' => $media->album->category->slug, 'url' => ['/media/category/'.$media->album->category->slug]];
	$this->params['breadcrumbs'][] = ['label' => $media->album->slug, 'url' => ['/media/album/'.$media->album->slug]];
}
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-cloud-download"></i> '. Yii::t('core', 'Download file'), $media->getThumbUrl('original'), ['download' => $media->filename, 'class' => 'btn btn-primary btn-sm']),
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Open file in a new tab'), $media->getThumbUrl('original'), ['target' => '_blank', 'class' => 'btn btn-success btn-sm']),
];
$icon = CoreHelper::getIcon($media->type);
?>
<div class="fixed-fluid">
    <div class="fixed-lg-300 pull-lg-right">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"> <?= Yii::t('core/media', 'Media Details'); ?></h3>
            </div>
            <div class="list-group bg-trans">
                <a class="list-group-item"><i class="ti-user icon-lg icon-fw"></i> <b><?= Yii::t('core', 'Author') ?>:</b> <?= ($media->created_by) ? (($media->author) ? $media->author->fullname : 'DELETED') : 'GUEST' ?></a>
                <a class="list-group-item"><i class="ti-flag-alt icon-lg icon-fw"></i> <b><?= Yii::t('core', 'Type') ?>:</b> <?= $media->type ?></a>
                <a class="list-group-item"><i class="ti-calendar icon-lg icon-fw"></i> <b><?= Yii::t('core', 'Uploaded') ?>:</b> <?= TimeAgo::widget(['timestamp' => $media->created_at, 'showDateTime' => true]); ?></a>
                <a class="list-group-item"><i class="ti-calendar icon-lg icon-fw"></i> <b><?= Yii::t('core', 'Updated') ?>:</b> <?= TimeAgo::widget(['timestamp' => $media->updated_at, 'showDateTime' => true]); ?></a>
                <a class="list-group-item"><i class="ti-ruler-alt icon-lg icon-fw"></i> <b><?= Yii::t('core/media', 'File Size') ?>:</b> <?= $media->getFileSize() ?></a>
            </div>
        </div>
    </div>
    <div class="fluid">
        <div class="panel">
            <div class="panel-body">
                <div class="media-block">
                    <a class="media-left"><img class="img-circle img-sm" alt="Profile Picture" src="<?= $media->author->getAvatar('large') ?>"></a>
                    <div class="media-body">
                        <div>
	                        <?= Yii::t('core/media', 'Shared by') ?>
                            <a class="btn-link text-semibold media-heading box-inline"><?= $media->author->fullname; ?></a>
                            <?php if($media->album): ?>
	                            <?= Yii::t('core/media', 'on album') ?> <a class="text-semibold" href="<?= '/media/album/' .$media->album->slug ;?>"><?= $media->album->title; ?></a>
                            <?php endif; ?>
                            <p>
                                <span class="text-muted">
                                    <i class="ti-time icon-lg"> </i>
		                            <?= TimeAgo::widget(['timestamp' => $media->created_at, 'showDateTime' => true, 'showEntireDate' => true]); ?>
                                </span>
                            </p>
                        </div>
                        <?php if ($media->isImage()): ?>
                            <img class="img-responsive" src="<?= $media->getThumbUrl('original'); ?>" alt="<?= $media->filename ?>">
                        <?php elseif ($media->isVideo()): ?>
                            <video controls="controls" width="100%"><source src="<?= $media->getThumbUrl('original'); ?>" type="<?= $media->type ?>"></video>
                        <?php elseif ($media->isAudio()): ?>
                            <audio src="<?= $media->getThumbUrl('original'); ?>" controls="controls" style="width: 100%;"></audio>
                        <?php else: ?>
                            <a href="<?= $media->getThumbUrl('original'); ?>" target="_blank">
                                <i class="<?= $icon['name'] ;?>" style="color:<?= $icon['color'] ;?>; font-size: 120px; line-height: 120px; opacity: .9;"></i>
                            </a>
                        <?php endif; ?>
                        <p class="pad-top">
		                    <?php if($media->description): ?>
			                    <?= $media->description ;?>
		                    <?php else: ?>
			                    <?= Yii::t('core/media', 'The file has no description.'); ?>
		                    <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fluid">
	    <?php if($media->isPdf()) :?>
		    <?= PdfViewer::widget(['url' => $media->getThumbUrl('original')]); ?>
	    <?php endif; ?>

	    <?php echo Comments::widget(['model' => Media::className(), 'model_id' => $media->id]); ?>
    </div>
</div>