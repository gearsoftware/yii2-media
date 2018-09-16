<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\assets\language\LanguagePillsAsset;
use gearsoftware\media\assets\ModalAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('core/media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/media', 'Manage Albums'), ['/media/album'], ['class' => 'btn btn-success btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/media', 'Manage Categories'), ['/media/category'], ['class' => 'btn btn-success btn-sm']),
];

ModalAsset::register($this);
LanguagePillsAsset::register($this);

echo gearsoftware\media\widgets\Gallery::widget(['pageSize' => 24, 'mode' => 'normal']);
