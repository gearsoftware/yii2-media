<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

/** @var \dosamigos\fileupload\FileUploadUI $this */

use gearsoftware\helpers\Html;
use gearsoftware\media\models\Album;
use gearsoftware\widgets\ActiveForm;
use kartik\widgets\Select2;

$context = $this->context;
?>

<!-- The file upload form used as target for the file upload widget -->
<?php
$form = ActiveForm::begin([
	'id' => 'upload',
	'action' => $context->url,
	'method' => 'post',
	'options' => $context->options,
	'fieldConfig' => ['template' => "{input}\n{hint}\n{error}"],
]);
?>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-sm-3">
            <div class="form-group mar-no">
			    <?= $form->field($context->model, 'set_album')->widget(Select2::classname(), [
				    'data' => Album::getAlbums(true, true),
				    'options' => [
					    'placeholder' => Yii::t('core', 'Select an {element}...', ['element' => Yii::t('core/media', 'Album')]),
					    'class' => 'form-control mar-no'
				    ],
				    'pluginOptions' => [
					    'allowClear' => true
				    ],
				    'addon' => [
					    'prepend' => [
						    'content' => '<i class="ti-sharethis"></i>'
					    ],
				    ]
			    ]);?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button" style="width: 100%;">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span><?= Yii::t('core/media', 'Add files') ?>...</span>
		            <?= $context->model instanceof \yii\base\Model && $context->attribute !== null
			            ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions)
			            : Html::fileInput($context->name, $context->value, $context->fieldOptions); ?>
                </span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-primary start submit-button" style="width: 100%;">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span><?= Yii::t('core/media', 'Start upload') ?></span>
                </span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-default cancel cancel-button" style="width: 100%;">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?= Yii::t('core/media', 'Cancel upload') ?></span>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
            <!-- The global progress state -->
            <div class="fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-xl active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <div style="overflow: auto;">
        <table role="presentation" class="table table-striped">
            <tbody class="files"></tbody>
        </table>
    </div>

<?php ActiveForm::end(); ?>

<?php

$js = <<< JS
    $('.submit-button').click(function(){
        $('.upload').submit();
    });
    $('.reset-button').click(function(){
        $('.upload').reset();
    });
JS;
$this->registerJs($js);

$css = <<<CSS
.fileupload-progress.fade{
    display: none;
}
.fileupload-progress.fade.in{
    display: initial;
}
.progress{
    margin-bottom: 0;
}
.progress-extended{
    text-align: center;
    margin-bottom: 15px;
}
.template-upload.fade.in >td, .template-download.fade.in >td{
    vertical-align: middle;
}
.template-upload.fade.in >td{
    min-width: 200px;
}
.template-download.fade.in >td{
    min-width: 100px;
}
CSS;
$this->registerCss($css);
