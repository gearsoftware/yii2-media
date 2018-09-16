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

use gearsoftware\media\models\Media;
use yii\web\NotFoundHttpException;

class Viewer extends \yii\base\Widget
{
	/**
	 * Media id to display
	 *
	 * @var int
	 */
	public $mediaId;

    public function run()
    {
    	$media = Media::find()->visible()->joinWith('translations')->andWhere([Media::tableName().'.id' => $this->mediaId])->one();
	    if (!$media) {
		    throw new NotFoundHttpException('Media was not found.');
	    }
	    return $this->render('view', compact('media'));
    }
}