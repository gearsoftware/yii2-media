<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\comments\models\Comment;
use gearsoftware\helpers\CoreHelper;
use gearsoftware\media\models\Media;
use gearsoftware\widgets\TimeAgo;

?>
<?php
    switch ($mode){
        case 'normal':
	        $url = '#mediafile';
        break;
        case 'dashboard':
	    case 'gallery':
	        $url = Yii::$app->urlManager->hostInfo.'/media/'.$model->id;
        break;
    }
?>
<a href="<?= $url; ?>" <?= ($mode == 'normal') ? 'data-key='.$key : '' ?> class="thumbnail">
	<?php if ($model->isImage()): ?>
		<div class="mail-file-img">
			<img class="image-responsive" src="<?= $model->getThumbUrl('medium') ?>" alt="image">
		</div>
	<?php else: ?>
		<div class="mail-file-icon">
			<?=  CoreHelper::getIconTag($model->type); ?>
		</div>
	<?php endif; ?>
    <div class="caption">
        <p class="text-primary mar-no text-overflow">
	        <?php if ($model->title): ?>
		        <?= $model->title; ?>
	        <?php else: ?>
		        <?= Yii::t('core', '(not set)'); ?>
	        <?php endif; ?>
        </p>
        <small class="text-muted text-overflow">
	        <?= Yii::t('core', 'Added:'); ?>
	        <?= TimeAgo::widget(['timestamp' => $model->created_at]); ?>
        </small>
    </div>
</a>