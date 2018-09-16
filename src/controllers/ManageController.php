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
use gearsoftware\media\assets\MediaAsset;
use gearsoftware\media\models\Media;
use gearsoftware\models\User;
use gearsoftware\timeline\controllers\TimelineTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;

class ManageController extends BaseController
{
	use TimelineTrait;

    public $modelClass = 'gearsoftware\media\models\Media';

    public $enableCsrfValidation = false;
    public $disabledActions = ['view', 'create', 'toggle-attribute', 'bulk-activate',
        'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size'];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ]);
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = '@vendor/gearsoftware/yii2-media/views/layouts/main';

	    return $this->render('index');
    }

    public function actionUploader()
    {
        $mode = Yii::$app->getRequest()->get('mode', 'normal');

	    if ($mode == 'modal') {
		    $this->layout = '@vendor/gearsoftware/yii2-media/views/layouts/main';
	    }

        return $this->render('uploader', [
            'mode' => $mode,
            'model' => new Media(),
        ]);
    }

    /**
     * Provides upload file
     * @return mixed
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Media();

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $album_id = $data['Media']['set_album'];
            $model->album_id = $album_id;
        }

        $routes = $this->module->routes;
        $rename = $this->module->rename;

        try {
            $model->saveUploadedFile($routes, $rename);
        } catch (\Exception $exc) {
            $response['files'][] = [
                'error' => $exc->getMessage()
            ];
            return $response;
        }

        $bundle = MediaAsset::register($this->view);

        if ($model->isImage()) {
            $model->createThumbs($routes, $this->module->thumbs);
        }

        $response['files'][] = [
            'url' => $model->url,
            'thumbnailUrl' => $model->getDefaultThumbUrl(),
            'FA' => CoreHelper::getIcon($model->type),
            'name' => $model->filename,
            'type' => $model->type,
            'size' => $model->file->size,
            'deleteUrl' => Url::to(['manage/delete', 'id' => $model->id]),
            'deleteType' => 'POST',
        ];

	    $this->model_class = Media::class;
	    $this->model_class_id = $model->id;
	    $this->model_created_at = $model->created_at;
	    $this->saveTimeline();

        return $response;
    }

    /**
     * Updated media by id
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

	    $tableName = Media::tableName();

	    /**
	     * @var Media
	     */
	    $model = Media::findOne(["{$tableName}.id" => $id]);
	    $message = Yii::t('core/media', "Changes haven't been saved.");

	    if (User::hasPermission('editMedia')) {
		    if ($model->load(Yii::$app->request->post()) && $model->save()) {
			    $message = Yii::t('core/media', "Changes have been saved.");
		    }

		    Yii::$app->session->setFlash('mediaUpdateResult', $message);
	    } else {
		    die(Yii::t('yii', 'You are not allowed to perform this action.'));
	    }

	    return $this->renderPartial('info', [
		    'model' => $model,
		    'strictThumb' => null,
	    ]);
    }

    /**
     * Delete model with medias
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $routes = $this->module->routes;

        $tableName = Media::tableName();

        /**
         * @model gearsoftware\media\models\Media
         */
        $model = Media::findOne(["{$tableName}.id" => $id]);

        if (User::hasPermission('deleteMedia')) {
            if ($model->isImage()) {
                $model->deleteThumbs($routes);
            }

            $model->deleteFile($routes);
            $model->delete();
	        Yii::$app->session->setFlash('mediaUpdateResult', Yii::t('core', 'Your item has been deleted.'));
            return ['success' => 'true'];
        } else {
            die(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Resize all thumbnails
     * @model gearsoftware\media\models\Media
     */
    public function actionResize()
    {
        $models = Media::findByTypes(Media::$imageFileTypes);
        $routes = $this->module->routes;

        foreach ($models as $model) {
            if ($model->isImage()) {
                $model->deleteThumbs($routes);
                $model->createThumbs($routes, $this->module->thumbs);
            }
        }

        Yii::$app->session->setFlash('primary', Yii::t('core/media', 'Thumbnails sizes has been resized successfully!'));
        $this->redirect(Url::to(['default/settings']));
    }

    /** Render model info
     * @param int $id
     * @param string $strictThumb only this thumb will be selected
     * @return string
     */
    public function actionInfo($id, $strictThumb = null)
    {
        $tableName = Media::tableName();

        /**
         * @model gearsoftware\media\models\Media
         */
        $model = Media::findOne(["{$tableName}.id" => $id]);

        return $this->renderPartial('info', [
            'model' => $model,
            'strictThumb' => $strictThumb,
        ]);
    }
}