<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Book;

/**
 * BookSearch represents the model behind the search form of `common\models\Book`.
 */
class BookSearch extends Book
{
    /** @var  string */
    public $date_publish_start;

    /** @var  string */
    public $date_publish_end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_publish_start','date_publish_end'],'string'],
            [['id', 'date_create', 'date_update', 'date', 'author_id'], 'integer'],
            [['name', 'preview'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'date' => $this->date,
            'author_id' => $this->author_id,
        ]);

        if($this->date_publish_start && $this->date_publish_end) {
            $query->andFilterWhere(['BETWEEN','date',strtotime($this->date_publish_start),strtotime($this->date_publish_end)]);
        }

        if($this->date_publish_start && !$this->date_publish_end) {
            $query->andFilterWhere(['>','date',strtotime($this->date_publish_start)]);
        }

        if(!$this->date_publish_start && $this->date_publish_end) {
            $query->andFilterWhere(['<','date',strtotime($this->date_publish_end)]);
        }


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'preview', $this->preview]);

        return $dataProvider;
    }
}
