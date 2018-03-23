<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_venta_vendedor".
 *
 * @property integer $id_venta
 * @property integer $id_vendedor
 * @property integer $num_porcentaje
 *
 * @property EntVendedores $idVendedor
 * @property WrkVentas $idVenta
 */
class RelVentaVendedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_venta_vendedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_vendedor', 'num_porcentaje'], 'required'],
            [['id_venta', 'id_vendedor', 'num_porcentaje'], 'integer'],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
            [['id_venta'], 'exist', 'skipOnError' => true, 'targetClass' => WrkVentas::className(), 'targetAttribute' => ['id_venta' => 'id_venta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_venta' => 'Id Venta',
            'id_vendedor' => 'Id Vendedor',
            'num_porcentaje' => 'Num Porcentaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedor()
    {
        return $this->hasOne(EntVendedores::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVenta()
    {
        return $this->hasOne(WrkVentas::className(), ['id_venta' => 'id_venta']);
    }
}
