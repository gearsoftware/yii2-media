<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\grid\GridView;
use gearsoftware\helpers\Html;
use gearsoftware\media\models\Album;
use gearsoftware\media\models\Category;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel gearsoftware\media\models\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core/media', 'Albums');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/media', 'Media'), 'url' => ['/media/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Add New'), ['/media/album/create'], ['class' => 'btn btn-primary btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/media', 'Manage Categories'), ['/media/category/'], ['class' => 'btn btn-success btn-sm']),
];

echo GridView::widget([
	'id' => 'media-album-grid',
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
			'attribute' => 'category_id',
			'label' => Yii::t('core', 'Category'),
			'value' => function (Album $model) {
				return ($model->category instanceof Category) ? $model->category->title : null;
			},
			'filterType' => GridView::FILTER_SELECT2,
			'filter' => Category::getCategories(true),
			'filterWidgetOptions' => [
				'pluginOptions' => ['allowClear' => true],
			],
			'filterInputOptions' => [
				'placeholder' => Yii::t('core', 'Select an {element}...', ['element' => Yii::t('core', 'Category')])
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