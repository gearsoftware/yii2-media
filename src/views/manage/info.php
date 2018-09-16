<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\helpers\Html;
use gearsoftware\media\assets\MediaAsset;
use gearsoftware\media\models\Album;
use gearsoftware\models\User;
use gearsoftware\widgets\ActiveForm;
use gearsoftware\widgets\LanguagePills;
use gearsoftware\widgets\TimeAgo;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model gearsoftware\media\models\Media */
/* @var $form gearsoftware\widgets\ActiveForm */

$bundle = MediaAsset::register($this);
$mode = Yii::$app->getRequest()->get('mode', 'normal');
?>

<?php if ($model->isMultilingual() && ($mode !== 'modal')): ?>
	<?= LanguagePills::widget() ?>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('mediaUpdateResult')): ?>
    <div class="alert alert-info alert-dismissible mar-no" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?= Yii::$app->session->getFlash('mediaUpdateResult') ?>
    </div><br/>
<?php endif; ?>

<div class="clearfix info">
    <ul class="detail">
        <li><b><?= Yii::t('core', 'Author') ?>
                :</b> <?= ($model->created_by) ? (($model->author) ? $model->author->fullname : 'DELETED') : 'GUEST' ?>
        </li>
        <li><b><?= Yii::t('core', 'Type') ?>:</b> <?= $model->type ?></li>
        <li><b><?= Yii::t('core', 'Uploaded') ?>:</b>
	        <?= TimeAgo::widget(['timestamp' => $model->created_at, 'showDateTime' => true]); ?>
        </li>
        <li><b><?= Yii::t('core', 'Updated') ?>:</b>
	        <?= TimeAgo::widget(['timestamp' => $model->updated_at, 'showDateTime' => true]); ?>
        </li>
        <?php if ($model->isImage()) : ?>
            <li><b><?= Yii::t('core/media', 'Dimensions') ?>
                    :</b> <?= $model->getOriginalImageSize($this->context->module->routes) ?></li>
        <?php endif; ?>
        <li><b><?= Yii::t('core/media', 'File Size') ?>:</b> <?= $model->getFileSize() ?></li>
        <li><b><?= Yii::t('core', 'File URL'); ?>: </b>
            <?= Html::a($model->getThumbUrl('original'),  $model->getThumbUrl('original'), ['target' => '_blank', 'class' => 'link']); ?>
        </li>
        <li><b><?= Yii::t('core', 'Comment media URL'); ?>: </b>
		    <?= Html::a(Yii::$app->urlManager->hostInfo.'/media/'.$model->id,  Yii::$app->urlManager->hostInfo.'/media/'.$model->id, ['target' => '_blank', 'class' => 'link']); ?>
        </li>
    </ul>
</div>

<?php
$form = ActiveForm::begin([
    'action' => ['/media/manage/update', 'id' => $model->id],
    'options' => ['id' => 'control-form'],
]);
?>

<?php /*echo $form->field($model, 'url')->textInput([
    'class' => 'form-control input-sm',
    'readonly' => 'readonly',
    'value' => Yii::$app->urlManager->hostInfo . $model->url,
]);*/ ?>

<?php if ($mode !== 'modal'): ?>

    <?php if (User::hasPermission('editMedia')): ?>
        <?= $form->field($model, 'album_id')->dropDownList(ArrayHelper::merge([NULL => Yii::t('core', 'Not Selected')], Album::getAlbums(true, true))) ?>
        <?= $form->field($model, 'title')->textInput(['class' => 'form-control input-sm']); ?>
    <?php else: ?>
        <?= $form->field($model, 'album_id')->dropDownList(ArrayHelper::merge([NULL => Yii::t('core', 'Not Selected')], Album::getAlbums(true, true)), ['readonly' => 'readonly']) ?>
        <?= $form->field($model, 'title')->textInput(['class' => 'form-control input-sm', 'readonly' => 'readonly']); ?>
    <?php endif; ?>

<?php endif; ?>

<?php if ($model->isImage()) : ?>
    <?php if (User::hasPermission('editMedia')): ?>
        <?= $form->field($model, 'alt')->textInput(['class' => 'form-control input-sm']); ?>
    <?php else: ?>
        <?= $form->field($model, 'alt')->textInput(['class' => 'form-control input-sm', 'readonly' => 'readonly']); ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($mode !== 'modal'): ?>
    <?php if (User::hasPermission('editMedia')): ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4, 'class' => 'form-control input-sm']); ?>
    <?php else: ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4, 'class' => 'form-control input-sm', 'readonly' => 'readonly']); ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($model->isImage() && ($mode == 'modal')) : ?>
    <div class="form-group<?= $strictThumb ? ' hidden' : '' ?>">
        <?= Html::label(Yii::t('core/media', 'Select image size'), 'image', ['class' => 'control-label']) ?>
        <?= Html::dropDownList('url', $model->getThumbUrl($strictThumb), $model->getImagesList($this->context->module), ['class' => 'form-control input-sm']) ?>
        <div class="help-block"></div>
    </div>
<?php else : ?>
    <?= Html::hiddenInput('url', $model->url) ?>
<?php endif; ?>

<?= Html::hiddenInput('id', $model->id) ?>

<?php if (User::hasPermission('editMedia') && ($mode != 'modal')): ?>
	<?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php endif; ?>

<?php if ($mode == 'modal'): ?>
	<?= Html::button(Yii::t('core', 'Insert'), ['id' => 'insert-btn', 'class' => 'btn btn-primary']) ?>
<?php endif; ?>

<?= Html::a(Yii::t('core', 'Download'),  $model->getThumbUrl('original'), ['download' => $model->filename, 'class' => 'btn btn-success']); ?>

<?php if ($mode !== 'modal'): ?>
	<?=
	Html::a(Yii::t('core', 'Delete'), ['/media/manage/delete', 'id' => $model->id], [
		'class' => 'btn btn-default pull-right',
		'data-message' => Yii::t('core', 'Are you sure you want to delete this item?'),
		'data-id' => $model->id,
		'role' => 'delete',
	])
	?>
<?php endif; ?>

<?php ActiveForm::end(); ?>