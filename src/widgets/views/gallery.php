<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\grid\DateRangePicker;
use gearsoftware\helpers\Html;
use gearsoftware\media\assets\MediaAsset;
use gearsoftware\media\models\Album;
use kartik\widgets\Select2;
use yii\grid\GridViewAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use gearsoftware\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel gearsoftware\media\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['moduleBundle'] = MediaAsset::register($this);
$this->params['gallery'] = $gallery;

GridViewAsset::register($this);

?>

<?php
if($mode == 'modal'){
    $action =  Url::to(['/media/manage/index']);
}else{
	$action  = Url::to(['/media/default/index']);
}
if($gallery){
	$action  = Url::to(['/media']);
}

$form = ActiveForm::begin([
	'id' => 'gallery',
	'action' => $action,
	'method' => 'get',
	'validateOnBlur' => true,
	'fieldConfig' => [
        'template' => "{label}{input}\n{hint}\n{error}",
        'options' => [
	        'class' => 'form-group mar-no',
        ],
    ]
]);
?>

<div class="giant-dropdown-panel" id="gallery-grid-filters">
    <div class="row">
        <div class="giant-dropdown-group">
            <div class="form-group mar-no">
                <div class="giant-dropdown-input">
                    <span class="input-group-addon pad-no"><i class="demo-pli-magnifi-glass icon-lg"></i></span>
		            <?= $form->field($searchModel, 'title', ['enableLabel' => false, 'showErrors' => false])
		                     ->textInput(['placeholder' => $searchModel->attributeLabels()['title'], 'style' => 'border-radius: 0;']) ?>
                    <div class="input-group-btn giant-dropdown">
                        <a class="giant-dropdown-toggle btn btn-success">
                            <i class="pli-arrow-down-in-circle icon-lg"></i>
                        </a>
                        <div class="dropdown-menu giant-dropdown-menu">
                            <div class="giant-dropdown-header">
                                <button type="button" class="close" data-tool="close"><i class="pci-cross pci-circle"></i></button>
                                <h4 class="giant-dropdown-title">Menu #1</h4>
                            </div>
                            <div class="giant-dropdown-content">
                                <div class="form-horizontal">
	                                <?= $form->field($searchModel, 'album_id', ['labelOptions' => [ 'class' => 'col-sm-4']])
                                         ->widget(Select2::classname(), [
                                            'data' => ArrayHelper::merge([0 => Yii::t('core/media', 'All Media Items')], Album::getAlbums(true, true, $onlyVisible)),
                                            'options' => [
                                                'placeholder' => Yii::t('core', 'Select an {element}...', ['element' => Yii::t('core/media', 'Album')])
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
	                                <?= $form->field($searchModel, 'created_at',  ['labelOptions' => [ 'class' => 'col-sm-4']])
                                         ->widget(DateRangePicker::className(), [
                                             'containerOptions' => ['class' => 'col-sm-8 pad-no'],
                                         ]) ?>
                                </div>
                            </div>
                            <div class="giant-dropdown-footer">
                                <button class="btn btn-default" type="button" data-tool="close">Close</button>
                                <button class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row <?= $mode ?>-media-frame">
    <div <?= ($gallery) ? 'class="col-sm-12"' : 'class="col-sm-8"'; ?>>
        <div <?= ($mode == 'normal') ? 'class="panel"' : '' ?>>
            <div <?= ($mode == 'normal') ? 'class="panel-body"' : '' ?>>
                <div id="media" data-frame-mode="<?= $mode ?>" data-url-info="<?= Url::to(['/media/manage/info']) ?>">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => '<ul class="mail-attach-list list-ov">{items}</ul><div class="text-center">{pager}</div>',
                        'itemOptions' => ['tag' => 'li', 'class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            if($this->params['gallery']){
	                            $mode = 'gallery';
                            }else{
                                $mode = 'normal';
                            }
                            return $this->render('item', compact('model', 'mode', 'key'));
                        },
                        'pager' => [
	                        'options' => [
		                        'class' => 'pagination pagination-sm',
		                        'style' => 'display: inline-block;',
	                        ],
	                        'hideOnSinglePage' => true,
	                        'firstPageLabel' => '<<',
	                        'prevPageLabel' => '<',
	                        'nextPageLabel' => '>',
	                        'lastPageLabel' => '>>',
	                        'maxButtonCount' => 4
                        ],
                    ])?>
                </div>
            </div>
        </div>
    </div>
	<?php if (!$gallery) : ?>
        <div class="col-sm-4">
            <div <?= ($mode == 'normal') ? 'class="panel" style="margin-bottom: 0;"' : '' ?>>
                <div <?= ($mode == 'normal') ? 'class="panel-body media-details" style="padding-bottom: 15px;"' : 'class="media-details"' ?>>
                    <div class="dashboard" <?= ($mode == 'modal') ? 'style="padding-bottom: 15px;"' : '' ?>>
                        <h4><?= Yii::t('core/media', 'Media Details') ?>:</h4>
                        <div id="fileinfo">
                            <blockquote class="bq-sm bq-open bq-close mar-no pad-no" style="border-left: none;"><?= Yii::t('core/media', 'Please, select file to view details.') ?></blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>

<?php

//Init AJAX filter submit
$options = '{"filterUrl":"' . Url::to(['default/index']) . '","filterSelector":"#gallery-grid-filters input, #gallery-grid-filters select"}';
$this->registerJs("jQuery('#gallery').yiiGridView($options);");

?>
