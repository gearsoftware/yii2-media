<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\media\controllers;

use gearsoftware\controllers\BaseController;
use gearsoftware\helpers\CoreHelper;
use Yii;
use yii\helpers\Url;
use yii\web\Request;

class DefaultController extends BaseController
{

    public $disabledActions = ['view', 'create', 'update', 'delete', 'toggle-attribute',
        'bulk-activate', 'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size'];

    public function actionIndex()
    {
	    $mode = Yii::$app->getRequest()->get('mode', 'not-set');
	    if($mode == 'normal'){
		    return $this->render('index');
	    }elseif ($mode == 'modal'){
		    $this->layout = '@vendor/gearsoftware/yii2-media/views/layouts/main';
		    return Yii::$app->response->redirect(Url::to(['/media/manage/index']));
	    }

	    $data = Yii::$app->request->get();
	    if (isset($data['MediaSearch'])) {
		    if(isset($data['MediaSearch']['mode'])){
				$mode = $data['MediaSearch']['mode'];
			    if($mode == 'normal'){
				    return $this->render('index');
			    }elseif ($mode == 'modal'){
				    $this->layout = '@vendor/gearsoftware/yii2-media/views/layouts/main';
				    return Yii::$app->response->redirect(Yii::$app->request->referrer);
			    }
		    }
	    }

	    $info = CoreHelper::getInfoFromUrl(Yii::$app->request->referrer, '/admin');
	    if($info['controller'] == 'media' && $info['action'] == 'manage'){
		    $this->layout = '@vendor/gearsoftware/yii2-media/views/layouts/main';
		    return Yii::$app->response->redirect(Url::to(['/media/manage/index']));
	    }

        return $this->render('index');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }

    public function actionComment($id)
    {
        $tableName = Media::tableName();
        $model = Media::findOne(["{$tableName}.id" => $id]);
        return $this->render('comment', compact('model'));
    }

}