<?php

namespace app\modules\report\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\report\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\modules\report\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_time', 'total', 'status'], 'integer'],
            [['user_order_name', 'user_order_phone', 'user_order_email', 'user_receive_name', 'user_receive_phone', 'user_receive_email', 'user_receive_address', 'user_note', 'admin_note'], 'safe'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
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
            'total' => $this->total,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_order_name', $this->user_order_name])
            ->andFilterWhere(['like', 'user_order_phone', $this->user_order_phone])
            ->andFilterWhere(['like', 'user_order_email', $this->user_order_email])
            ->andFilterWhere(['like', 'user_receive_name', $this->user_receive_name])
            ->andFilterWhere(['like', 'user_receive_phone', $this->user_receive_phone])
            ->andFilterWhere(['like', 'user_receive_email', $this->user_receive_email])
            ->andFilterWhere(['like', 'user_receive_address', $this->user_receive_address])
            ->andFilterWhere(['like', 'user_note', $this->user_note])
            ->andFilterWhere(['like', 'admin_note', $this->admin_note]);

        if (!empty($this->order_time['from_date'])) {
            $query->andFilterWhere(['>=', $this->tableName() . ".order_time", AppLocale::getTimeOfDate($this->order_time['from_date'], $format)]);
        }

        if (!empty($this->order_time['to_date'])) {
            $todate = AppLocale::getTimeOfDate($this->order_time['to_date'], $format);
            $query->andFilterWhere(['<=', $this->tableName() . ".order_time", $todate + 86399]); //add tim 23:59:59
        }

        if (!empty($this->order_time['from_date'])) {
            $query->andFilterWhere(['>=', 'account_request.order_date', strtotime(Carbon::createFromFormat('d-m-Y', $this->order_time['from_date'])->toDateString())]);
        }

        if (!empty($this->order_time['to_date'])) {
            $query->andFilterWhere(['<=', 'account_request.order_date', strtotime(Carbon::createFromFormat('d-m-Y', $this->order_time['to_date'])->toDateString())]);
        }

        return $dataProvider;
    }
}
