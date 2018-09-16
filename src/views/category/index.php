<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\grid\GridPageSize;
use gearsoftware\grid\GridView;
use gearsoftware\helpers\Html;
use gearsoftware\media\models\Category;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \gearsoftware\media\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core/media', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Media'), 'url' => ['/media/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Albums'), 'url' => ['/media/album/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Add New'), ['/media/category/create'], ['class' => 'btn btn-primary btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/media', 'Manage Albums'), ['/media/album/index'], ['class' => 'btn btn-success btn-sm']),
];

echo GridView::widget([
	'id' => 'media-category-grid',
	'title' => $this->title,
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'bulkActionOptions' => [
		'actions' => [
			Url::to(['bulk-delete']) => Yii::t('core', 'Delete'),
		]
	],
	'columns' => [
		[
			'class' => 'gearsoftware\grid\columns\SerialColumn'
		],
		'title',
		'description:ntext',
		[
			'class' => 'gearsoftware\grid\columns\StatusColumn',
			'attribute' => 'visible',
			'filterType' => GridView::FILTER_SELECT2,
			'filterWidgetOptions' => [
				'pluginOptions' => ['allowClear' => true],
			],
			'filterInputOptions' => [
				'placeholder' => Yii::t('core', 'Select a {element}...', ['element' => Yii::t('core', 'Status')])
			],
			'format' => 'raw'
		],
		[
			'class' => 'gearsoftware\grid\columns\ActionColumn',
			'template' => '{update}{delete}',
			'dropdown' => true,
		],
		[
			'class' => 'gearsoftware\grid\columns\CheckboxColumn',
		],
	]
]);