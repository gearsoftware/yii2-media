<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\models;

use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Media]].
 *
 * @see Media
 */
class MediaQuery extends \yii\db\ActiveQuery
{
	use MultilingualTrait;

	public function visible()
	{
		$this
			->joinWith('album')
				->andWhere(['<>', Album::tableName().'.visible', 0])
			->joinWith('album.category')
				->andWhere(['<>', Category::tableName().'.visible', 0])
			->orWhere([Media::tableName().'.album_id' => NULL]);
		return $this;
	}

    /**
     * @inheritdoc
     * @return Media[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Media|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
