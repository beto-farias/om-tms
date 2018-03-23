<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntVendedores;

/**
 * VendedoresSearch represents the model behind the search form about `app\models\EntVendedores`.
 */
class VendedoresSearch extends EntVendedores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_rol', 'b_activo'], 'integer'],
            [['uddi', 'txt_nombre', 'txt_nombre_usuario', 'txt_contrasena'], 'safe'],
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
        $query = EntVendedores::find();

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
            'id_vendedor' => $this->id_vendedor,
            'id_rol' => $this->id_rol,
            'b_activo' => $this->b_activo,
        ]);

        $query->andFilterWhere(['like', 'uddi', $this->uddi])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_nombre_usuario', $this->txt_nombre_usuario])
            ->andFilterWhere(['like', 'txt_contrasena', $this->txt_contrasena]);

        return $dataProvider;
    }
}
