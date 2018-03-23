<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_venta_producto".
 *
 * @property integer $id_venta
 * @property integer $id_producto
 * @property integer $num_precio
 * @property integer $num_cantidad
 *
 * @property EntProductos $idProducto
 * @property WrkVentas $idVenta
 */
class RelVentaProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_venta_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_producto', 'num_precio', 'num_cantidad'], 'required'],
            [['id_venta', 'id_producto', 'num_precio', 'num_cantidad'], 'integer'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => EntProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
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
            'id_producto' => 'Id Producto',
            'num_precio' => 'Num Precio',
            'num_cantidad' => 'Num Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(EntProductos::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVenta()
    {
        return $this->hasOne(WrkVentas::className(), ['id_venta' => 'id_venta']);
    }
}
