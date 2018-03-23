<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_vendedores_clientes".
 *
 * @property integer $id_vendedor_cliente
 * @property integer $id_vendedor
 * @property integer $id_cliente
 * @property string $fch_alta
 * @property integer $b_actual
 *
 * @property EntClientes $idCliente
 * @property EntVendedores $idVendedor
 */
class RelVendedoresClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_vendedores_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_cliente'], 'required'],
            [['id_vendedor', 'id_cliente', 'b_actual'], 'integer'],
            [['fch_alta'], 'safe'],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => EntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor_cliente' => 'Id Vendedor Cliente',
            'id_vendedor' => 'Id Vendedor',
            'id_cliente' => 'Id Cliente',
            'fch_alta' => 'Fch Alta',
            'b_actual' => 'B Actual',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCliente()
    {
        return $this->hasOne(EntClientes::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedor()
    {
        return $this->hasOne(EntVendedores::className(), ['id_vendedor' => 'id_vendedor']);
    }
}
