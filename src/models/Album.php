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

use omgdef\multilingual\MultilingualQuery;
use gearsoftware\behaviors\MultilingualBehavior;
use gearsoftware\models\OwnerAccess;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use gearsoftware\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "media_album".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $slug
 * @property string $title
 * @property integer $visible
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Album extends ActiveRecord implements OwnerAccess
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media_album}}';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->className() == Album::className()) {
            $this->visible = 1;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'category_id', 'visible'], 'integer'],
            [['description'], 'string'],
            [['slug', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'media_album_id',
                'tableName' => "{{%media_album_lang}}",
                'attributes' => [
                    'title', 'description',
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core', 'ID'),
            'category_id' => Yii::t('core/media', 'Category'),
            'slug' => Yii::t('core', 'Slug'),
            'title' => Yii::t('core', 'Title'),
            'visible' => Yii::t('core', 'Visible'),
            'description' => Yii::t('core', 'Description'),
            'created_by' => Yii::t('core', 'Created By'),
            'updated_by' => Yii::t('core', 'Updated By'),
            'created_at' => Yii::t('core', 'Created'),
            'updated_at' => Yii::t('core', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Return all albums.
     *
     * @param bool $asArray return array
     * @param bool $withCategories Two-dimensional array with albums categories
     * @param bool $onlyVisible Show albums with column visible != 0 and category.visible != 0
     *
     * @return static[]
     */
    public static function getAlbums($asArray = false, $withCategories = false, $onlyVisible = false)
    {
        if (!$withCategories) {
        	if($onlyVisible){
		        $result = static::find()->where(['<>', 'visible', 0])->multilingual()->all();
	        }else{
		        $result = static::find()->multilingual()->all();
	        }
            return $asArray ? ArrayHelper::map($result, 'id', 'title') : $result;
        } else {
            $result = [];
            if($onlyVisible){
	            $categories = Category::find()->where(['<>', 'visible', 0])->multilingual()->all();
	            foreach ($categories as $category) {
		            $albums = [];
		            foreach ($category->albums as $album) {
			            if($album->visible != 0){
				            $albums[] = $album;
			            }
		            }
		            if($albums){
			            $result[$category->title] = ArrayHelper::map($albums, 'id', 'title');
		            }
	            }
            }else{
	            $categories = Category::find()->multilingual()->all();
	            foreach ($categories as $category) {
	            	if($category->albums){
			            $result[$category->title] = ArrayHelper::map($category->albums, 'id', 'title');
		            }
	            }
            }
            return $result;
        }
    }

    /**
     *
     * @inheritdoc
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     *
     * @inheritdoc
     */
    public static function getFullAccessPermission()
    {
        return 'fullMediaAlbumAccess';
    }

    /**
     *
     * @inheritdoc
     */
    public static function getOwnerField()
    {
        return 'created_by';
    }
}