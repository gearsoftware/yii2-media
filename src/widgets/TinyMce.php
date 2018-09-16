<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\widgets;

use gearsoftware\assets\core\MceContentAsset;
use gearsoftware\assets\fonts\OpenSansFontAsset;
use gearsoftware\media\assets\FileInputAsset;
use gearsoftware\helpers\Html;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;
use gearsoftware\media\assets\TinyMceAsset;

class TinyMce extends InputWidget
{

    /**
     * @var string Optional, if set, only this image can be selected by user
     */
    public $thumb = '';

    /**
     * @var string JavaScript function, which will be called before insert file data to input.
     * Argument data contains file data.
     * data example: [alt: "Witch with cat", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
     */
    public $callbackBeforeInsert = '';

    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
	public $clientOptions = [

	];

    /**
     * @inheritdoc
     */
    public function init()
    {
	    OpenSansFontAsset::register($this->getView());
	    $openSansBaseUrl = $this->getView()->assetBundles[OpenSansFontAsset::class]->baseUrl;
	    MceContentAsset::register($this->getView());
	    $mceContentBaseUrl = $this->getView()->assetBundles[MceContentAsset::class]->baseUrl;

	    $this->clientOptions = [
		    'menubar' => true,
		    'height' => 400,
		    'image_dimensions' => true,
		    'image_caption' => true,
		    //imagetools
		    'plugins' => [
			    'advlist autolink lists link image charmap print preview fullscreen hr anchor',
	            'searchreplace visualblocks visualchars code contextmenu table wordcount',
	            'pagebreak insertdatetime save media nonbreaking paste directionality emoticons template',
	            'textcolor fullpage colorpicker textpattern codesample toc help',
		    ],
		    'toolbar1' => 'undo redo | bold italic underline strikethrough | forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify bullist numlist outdent indent',
		    'toolbar2' => 'print preview | styleselect formatselect | fontselect fontsizeselect | pagebreak link image media table | code fullscreen help',
		    'toolbar_items_size' => 'small',
		    'content_css' => [
		    	$openSansBaseUrl.'/css/open-sans-font.css',
			    $mceContentBaseUrl.'/css/mce-content.css'
		    ],
		    'branding' => false,
		    'imagetools_cors_hosts' => [
			    Yii::$app->urlManager->hostInfo
		    ],
		    'font_formats' => 'Open Sans=Open Sans;Helvetica Neue=Helvetica Neue;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
			'language' => Yii::$app->core->getDisplayLanguageShortcode(Yii::$app->language),
	    ];

        parent::init();

        if (empty($this->clientOptions['file_picker_callback'])) {
            $this->clientOptions['file_picker_callback'] = new JsExpression(
                    'function(callback, value, meta) {
                    mediaTinyMCE(callback, value, meta);
                }'
            );
        }

        if (empty($this->clientOptions['document_base_url'])) {
            $this->clientOptions['document_base_url'] = '';
        }

        if (empty($this->clientOptions['convert_urls'])) {
            $this->clientOptions['convert_urls'] = false;
        }

        //todo, change image convert from base64 to source url. example: https://www.tinymce.com/docs/advanced/handle-async-image-uploads/#usinguploadimagesandthenpostingaform
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        if ($this->hasModel()) {
            $output = Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $output = Html::textarea($this->name, $this->value, $this->options);
        }

        $this->registerClientScript();

        $modal = $this->renderFile('@vendor/gearsoftware/yii2-media/views/manage/modal.php', [
            'inputId' => $this->options['id'],
            'btnId' => $this->options['id'] . '-btn',
            'frameId' => $this->options['id'] . '-frame',
            'frameSrc' => Url::to(['/media/manage']),
            'thumb' => $this->thumb,
        ]);

        return $output . $modal;
    }

    /**
     * Registers client scripts
     */
    protected function registerClientScript()
    {
        TinyMceAsset::register($this->view);
        FileInputAsset::register($this->view);

        $js = [];
        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#{$id}";

        $options = Json::encode($this->clientOptions);
        $js[] = "tinymce.init($options);";

        $this->view->registerJs(implode("\n", $js));

        if (!empty($this->callbackBeforeInsert)) {
            $this->view->registerJs('
                $("#' . $this->options['id'] . '").on("fileInsert", ' . $this->callbackBeforeInsert . ');'
            );
        }

        $this->view->registerJs("$('.mce-container-body .mce-toolbar-grp').addClass('hidden-xs-down');", View::POS_LOAD);
    }

}
