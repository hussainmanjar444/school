<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InventoryIssue;

/**
 * InventoryIssueSearch represents the model behind the search form about `app\models\InventoryIssue`.
 */
class InventoryIssueSearch extends InventoryIssue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'inventory_id', 'student_id', 'issue_by', 'recieved_by', 'status'], 'integer'],
            [['issued_date', 'issue_tilldate', 'return_date', 'request_date'], 'safe'],
            [['actual_fine', 'collected_fine'], 'number'],
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
        $query = InventoryIssue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'inventory_id' => $this->inventory_id,
            'student_id' => $this->student_id,
            'request_date' => $this->request_date,
            'issued_date' => $this->issued_date,
            'issue_tilldate' => $this->issue_tilldate,
            'return_date' => $this->return_date,
            'actual_fine' => $this->actual_fine,
            'collected_fine' => $this->collected_fine,
            'issue_by' => $this->issue_by,
            'recieved_by' => $this->recieved_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
