<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

/** @var \gearsoftware\media\widgets\uploader\FileUploader $this */
use gearsoftware\helpers\FA;
use gearsoftware\media\assets\UploaderAsset;
use yii\base\Model;
use yii\helpers\Html;

$context = $this->context;
$ownerModel = urlencode($context->ownerModel->className());
$formSelector = '#' . $context->options['id'];

$jsUnload = ''; 
if($context->bindBeforeUnload){
    $jsUnload = "$(window).bind('beforeunload', function () {
        return 'You have unsaved changes on this page. Are you sure you want to leave this page?';
    });";
}

$jsBind = <<<JS
    $('{$formSelector}')
    .bind('fileuploaddone', function (e, data) {
        if(data.textStatus === 'success'){
            var input = "<input type='hidden' name='{$context->inputName}[]' value='" + data.result.files[0].id + "'>";
            $("{$context->inputContainer}").append(input);
            {$jsUnload}
        }
    }).bind('fileuploaddestroy', function (e, data) {
        $("{$context->inputContainer}").find("input[value='" + data.id + "']").remove();
    });
JS;

$this->registerJs($jsBind);

if (!$context->ownerModel->isNewRecord) {
    $ownerId = $context->ownerModel->primaryKey;

    $jsLoad = <<<JS
    var form = $('{$formSelector}');
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: '{$context->baseUrl}/load',
        data: {owner_class: '{$ownerModel}', owner_id: {$ownerId}}
    }).done(function (data) {
        form.fileupload('option', 'done').call(form, $.Event('done'), {result: {files: data.files}});
    });
JS;

    $this->registerJs($jsLoad);
}

UploaderAsset::register($this);
?>

<div class="clearfix quick-upload">
    <?= Html::beginForm($context->url, 'post', $context->options); ?>

    <div role="presentation" class="files pull-left"></div>

    <div class="fileupload-buttonbar pull-left">
        <div class="btn btn-primary fileinput-button">
            <div style="vertical-align: middle;">
                <?= FA::icon(FA::_PLUS) ?>
                <span><?= Yii::t('core/media', 'Add files') ?></span>
                <?= $context->model instanceof Model && $context->attribute
                !== null ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions) : Html::fileInput($context->name, $context->value, $context->fieldOptions);
                ?>
            </div>
        </div>
    </div>

    <?= Html::endForm(); ?>
</div>