<?php

namespace app\modules\cronjob\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cronjob\models\Cronjob;

/**
 * CronjobSearch represents the model behind the search form of `app\modules\cronjob\models\Cronjob`.
 */
class CronjobSearch extends Cronjob
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'last_run',  'is_active', 'logging_f'], 'integer'],
            [['cronjob_id', 'name', 'class', 'module_id', 'run_rules'], 'safe'],
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
        $query = Cronjob::find();

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
            'last_run' => $this->last_run,
            'next_run' => $this->next_run,
            'is_active' => $this->is_active,
            'logging_f' => $this->logging_f,
        ]);

        $query->andFilterWhere(['like', 'cronjob_id', $this->cronjob_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'module_id', $this->module_id])
            ->andFilterWhere(['like', 'run_rules', $this->run_rules]);

        return $dataProvider;
    }
}
