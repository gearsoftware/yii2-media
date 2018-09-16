<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model gearsoftware\media\models\Album */

$this->title = Yii::t('core', 'Update {item}', ['item' => Yii::t('core/media', 'Album')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Media'), 'url' => ['/media/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Albums'), 'url' => ['/media/album/index']];
$this->params['breadcrumbs'][] = Yii::t('core', 'Update');
?>
<div class="album-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>