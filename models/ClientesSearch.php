<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntClientes;

/**
 * ClientesSearch represents the model behind the search form about `app\models\EntClientes`.
 */
class ClientesSearch extends EntClientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'b_habilitado'], 'integer'],
            [['uddi', 'txt_nombre', 'txt_correo', 'txt_telefono_fijo', 'txt_telefono_movil', 'fch_alta', 'txt_notas'], 'safe'],
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
        $query = EntClientes::find();

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
            'id_cliente' => $this->id_cliente,
            'fch_alta' => $this->fch_alta,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'uddi', $this->uddi])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_correo', $this->txt_correo])
            ->andFilterWhere(['like', 'txt_telefono_fijo', $this->txt_telefono_fijo])
            ->andFilterWhere(['like', 'txt_telefono_movil', $this->txt_telefono_movil])
            ->andFilterWhere(['like', 'txt_notas', $this->txt_notas]);

        return $dataProvider;
    }
}
