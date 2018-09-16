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

use gearsoftware\helpers\CoreHelper;
use gearsoftware\media\models\Media;
use gearsoftware\media\models\MediaSearch;
use gearsoftware\models\OwnerAccess;
use gearsoftware\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

class Gallery extends \yii\base\Widget
{
    /**
     * @var Media
     */
    public $modelClass = 'gearsoftware\media\models\Media';

    /**
     * @var MediaSearch
     */
    public $modelSearchClass = 'gearsoftware\media\models\MediaSearch';
    public $pageSize = 15;
    public $mode = 'normal';
    public $gallery = false;
    public $onlyVisible = false;

    public function run()
    {
        $modelClass = $this->modelClass;
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass : null;

        /* Not used in this case but this is needed to restrict access to user only the files where is the author.
        $restrictAccess = ( CoreHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
                            && !User::hasPermission($modelClass::getFullAccessPermission()));

	    $searchName = StringHelper::basename($searchModel::className());

		if ($restrictAccess) {
			$params[$searchName][$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
		}*/

	    $params = Yii::$app->request->getQueryParams();
	    $dataProvider = $searchModel->search($params, $this->onlyVisible);
        $dataProvider->pagination->defaultPageSize = $this->pageSize;

        return $this->render('gallery', [
                'searchModel' => $searchModel,
                'mode' => $this->mode,
                'gallery' => $this->gallery,
                'onlyVisible' => $this->onlyVisible,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}