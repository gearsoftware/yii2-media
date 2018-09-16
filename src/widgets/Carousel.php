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

use gearsoftware\helpers\Html;
use gearsoftware\media\models\Album;

/**
 * Widget to render Bootstrap Carousel with images from media album.
 *
 * Basic usage:
 * ~~~
 * use gearsoftware\media\widgets\Carousel;
 *
 * echo Carousel::widget(['album' => 'carousel'])
 *
 * //with custom views
 * echo Carousel::widget([
 *     'album' => 'carousel',
 *     'contentView' => '@frontend/views/carousel/content',
 *     'captionView' => '@frontend/views/carousel/caption',
 *     'itemsOptions' => ['class' => 'some-class']
 * ]);
 * ~~~
 */
class Carousel extends \yii\bootstrap\Carousel
{
    /**
     * Media album id or slug to display in Carousel
     *
     * @var string
     */
    public $album;

    /**
     * View file to render carousel content
     *
     * @var string
     */
    public $contentView = 'carousel-content';

    /**
     * View file to render carousel caption
     *
     * @var string
     */
    public $captionView = 'carousel-caption';

    /**
     * Options that will be applied to items
     *
     * @var array
     */
    public $itemsOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        /*if (ctype_digit($this->album)) {
            $condition = $this->album;
        } elseif (is_string($this->album)) {
            $condition = ['slug' => $this->album];
        } else {
            throw new \yii\base\InvalidParamException('Invalid album parameter passed to a method.');
        }*/

        $this->controls = [
            Html::icon('chevron-left'),
            Html::icon('chevron-right')
        ];

        $condition = $this->album;

        $album = Album::findOne($condition);

        if (!$album) {
            throw new \yii\web\NotFoundHttpException('Album was not found.');
        }

        $media = $album->getMedia()->limit(25)->orderBy(['created_at' => SORT_DESC])->all();

        foreach ($media as $image) {
            if($image->isImage()){
                $this->items[] = [
                    'content' => $this->render($this->contentView, ['image' => $image]),
                    'caption' => $this->render($this->captionView, ['image' => $image]),
                    'options' => $this->itemsOptions,
                ];
            }else{
                //todo, show img icon for file type
            }
        }
    }
}