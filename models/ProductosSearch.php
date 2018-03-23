<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntProductos;

/**
 * ProductosSearch represents the model behind the search form about `app\models\EntProductos`.
 */
class ProductosSearch extends EntProductos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto', 'id_categoria_producto', 'id_grupo_producto', 'id_marca_producto', 'id_producto_generico', 'num_precio', 'b_atributos', 'num_tamanio_paquete', 'b_habilitado'], 'integer'],
            [['txt_sku', 'txt_nombre', 'txt_description'], 'safe'],
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
        $query = EntProductos::find();

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
            'id_producto' => $this->id_producto,
            'id_categoria_producto' => $this->id_categoria_producto,
            'id_grupo_producto' => $this->id_grupo_producto,
            'id_marca_producto' => $this->id_marca_producto,
            'id_producto_generico' => $this->id_producto_generico,
            'num_precio' => $this->num_precio,
            'b_atributos' => $this->b_atributos,
            'num_tamanio_paquete' => $this->num_tamanio_paquete,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_sku', $this->txt_sku])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_description', $this->txt_description]);

        return $dataProvider;
    }
}
