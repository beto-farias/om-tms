<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_ventas".
 *
 * @property integer $id_venta
 * @property integer $id_cliente
 * @property integer $id_tienda
 * @property string $fch_venta
 *
 * @property RelVentaProducto[] $relVentaProductos
 * @property EntProductos[] $idProductos
 * @property RelVentaVendedor[] $relVentaVendedors
 * @property EntVendedores[] $idVendedors
 * @property EntClientes $idCliente
 * @property EntTiendas $idTienda
 */
class WrkVentas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_ventas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'id_tienda'], 'required'],
            [['id_cliente', 'id_tienda'], 'integer'],
            [['fch_venta'], 'safe'],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => EntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
            [['id_tienda'], 'exist', 'skipOnError' => true, 'targetClass' => EntTiendas::className(), 'targetAttribute' => ['id_tienda' => 'id_tienda']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_venta' => 'Id Venta',
            'id_cliente' => 'Id Cliente',
            'id_tienda' => 'Id Tienda',
            'fch_venta' => 'Fch Venta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVentaProductos()
    {
        return $this->hasMany(RelVentaProducto::className(), ['id_venta' => 'id_venta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductos()
    {
        return $this->hasMany(EntProductos::className(), ['id_producto' => 'id_producto'])->viaTable('rel_venta_producto', ['id_venta' => 'id_venta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVentaVendedors()
    {
        return $this->hasMany(RelVentaVendedor::className(), ['id_venta' => 'id_venta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedors()
    {
        return $this->hasMany(EntVendedores::className(), ['id_vendedor' => 'id_vendedor'])->viaTable('rel_venta_vendedor', ['id_venta' => 'id_venta']);
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
    public function getIdTienda()
    {
        return $this->hasOne(EntTiendas::className(), ['id_tienda' => 'id_tienda']);
    }
}
