<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\widgets\dashboard;

use gearsoftware\media\models\Media as MediaModel;
use gearsoftware\media\models\MediaSearch;
use gearsoftware\models\User;
use gearsoftware\widgets\DashboardWidget;
use Yii;

class Media extends DashboardWidget
{
    /**
     * Most recent post limit
     */
    public $recentLimit = 8;

    /**
     * Post index action
     */
    public $indexAction = 'media/default/index';

	/**
	 * Total media options
	 *
	 * @var array
	 */
	public $options;

    public function run()
    {
	    if (!$this->options) {
		    $this->options = $this->getDefaultOptions();
	    }

        if (User::hasPermission('viewMedia')) {
	        $searchModel = new MediaSearch();
	        $formName = $searchModel->formName();

            $recent = MediaModel::find()->multilingual()->orderBy(['id' => SORT_DESC])->limit($this->recentLimit)->all();

	        foreach ($this->options as &$option) {
		        $count = MediaModel::find()->filterWhere($option['filterWhere'])->count();
		        $option['count'] = $count;
		        $option['url'] = [$this->indexAction, $formName => $option['filterWhere']];
	        }

            return $this->render('media',
                [
                    'height' => $this->height,
                    'width' => $this->width,
                    'position' => $this->position,
                    'options' => $this->options,
                    'recent' => $recent,
                ]);
        }
    }

	public function getDefaultOptions()
	{
		return [
			['label' => Yii::t('core', 'Show All'), 'icon' => 'ok', 'filterWhere' => []],
		];
	}
}