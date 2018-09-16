<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

/* @var $this yii\web\View */

use yii\helpers\Url;

/* @var $item gearsoftware\media\models\Media */
?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-control hidden-xs-down">
            <ul class="pager pager-rounded">
			    <?php foreach ($options as $option) : ?>
                    <li><a href="<?=  Url::to($option['url']); ?>"><?= $option['label'] . ' ('. $option['count'] . ')'; ?></a></li>
			    <?php endforeach; ?>
            </ul>
        </div>
        <h3 class="panel-title"><?= Yii::t('core/media', 'Media Activity') ?></h3>
    </div>
    <div class="panel-body">
        <?php if (count($recent)): ?>
            <ul class="mail-attach-list list-ov text-center">
                <?php foreach ($recent as $model) : ?>
                    <li>
                        <?php
                            $mode = 'dashboard';
                            echo $this->render('@vendor/gearsoftware/yii2-media/widgets/views/item', compact('model', 'mode'));
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <em><?= Yii::t('core/media', 'No files found.') ?></em>
        <?php endif; ?>
    </div>
</div>