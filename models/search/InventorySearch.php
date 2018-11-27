<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inventory;

/**
 * InventorySearch represents the model behind the search form of `app\models\Inventory`.
 */
class InventorySearch extends Inventory
{
    public $author;
    public $category;
    public $publisher;
    public $book;
    public $isbn;
    public $keyword;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'book_id', 'school_id', 'quantity', 'status', 'created_on', 'created_by', 'updated_by', 'avaliable_quantity'], 'integer'],
            [['updated_on'], 'safe'],
            [['author', 'category', 'publisher', 'book', 'isbn', 'keyword'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Inventory::find();
        $query->joinWith("book");
        $query->joinWith("book.author");
        $query->joinWith("book.publisher");
        $query->joinWith("book.category");

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
            'book_id' => $this->book_id,
            'school_id' => $this->school_id,
            'quantity' => $this->quantity,
            'avaliable_quantity' => $this->avaliable_quantity,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'created_by' => $this->created_by,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['like', 'book.isbn', $this->isbn])
            ->andFilterWhere(['like', 'book.name', $this->book])
            ->andFilterWhere(['like', 'book_author.name', $this->author])
            ->andFilterWhere(['like', 'book_publisher.name', $this->publisher])
            ->andFilterWhere(['like', 'book_category.name', $this->category])
            ->orFilterWhere(['like', 'book.isbn', $this->keyword])
            ->orFilterWhere(['like', 'book.name', $this->keyword])
            ->orFilterWhere(['like', 'book_author.name', $this->keyword])
            ->orFilterWhere(['like', 'book_publisher.name', $this->keyword])
            ->orFilterWhere(['like', 'book_category.name', $this->keyword]);

        return $dataProvider;
    }
}
