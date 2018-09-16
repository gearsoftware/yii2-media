<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\widgets\uploader;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class UploaderInput extends InputWidget
{

    public $items = [];
    public $inline = false;

    /**
     * Runs the widget.
     */
    public function run()
    {
        if (!$this->hasModel()) {
            throw new \yii\base\InvalidConfigException();
        }

        $value = Html::getAttributeValue($this->model, $this->attribute);
        $name = Html::getInputName($this->model, $this->attribute);

        $content = Html::beginTag('div', $this->options);
        foreach ($value as $media_id) {
            $content .= Html::hiddenInput($name . '[]', $media_id);
        }
        $content .= Html::endTag('div');

        return $content;
    }

}
