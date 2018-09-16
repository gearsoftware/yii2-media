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

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MediaSearch represents the model behind the search form about `gearsoftware\media\models\Media`.
 */
class MediaSearch extends Media
{
	public $album_id = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'size', 'album_id', 'created_by', 'updated_by'], 'integer'],
            [['filename', 'type', 'created_at', 'updated_at', 'url', 'alt', 'description', 'thumbs', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param boolean $onlyVisible to show media that pass active query visible method
     *
     * @return ActiveDataProvider
     */
    public function search($params = [], $onlyVisible = false)
    {
    	if($onlyVisible){
		    $query = Media::find()->visible()->joinWith('translations');
	    }else{
		    $query = Media::find()->joinWith('translations');
	    }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->created_at) {
            $tmp = explode(' - ', $this->created_at);
            if (isset($tmp[0], $tmp[1])) {
                $query->andFilterWhere(['between', static::tableName() . '.created_at',
                    strtotime($tmp[0]), strtotime($tmp[1])]);
            }
        }

        $query->andFilterWhere([
	        static::tableName().'.album_id' => ($this->album_id == 0) ? '' : $this->album_id,
	        static::tableName().'.created_by' => $this->created_by,
	        static::tableName().'.updated_by' => $this->updated_by,
	        static::tableName().'.updated_at' => $this->updated_at,
        ]);


        $query->andFilterWhere(['like', 'media_lang.title', $this->title]);

	    return $dataProvider;
    }
}