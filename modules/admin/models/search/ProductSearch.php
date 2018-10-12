<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\admin\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'deleted_f'], 'integer'],
            [['code', 'name'], 'safe'],
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
        $query = Product::find()
            ->innerJoinWith((['category' => function($query) {
                $query->from(['category' => 'product_category']);
                $query->onCondition(['!=', 'category.deleted_f', 1]);
            }]));

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id',
                    'code',
                    'name',
                    'price',
                    'deleted_f',
                    'category.name'
                ]
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
            'product.id' => $this->id,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'product.deleted_f' => $this->deleted_f,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'image_main', $this->image_main]);

        return $dataProvider;
    }
}
