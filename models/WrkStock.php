<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_stock".
 *
 * @property integer $id_stock
 * @property integer $id_producto
 * @property integer $id_almacen
 * @property integer $num_cantidad
 *
 * @property EntAlmacenes $idAlmacen
 * @property EntProductos $idProducto
 */
class WrkStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto', 'id_almacen', 'num_cantidad'], 'required'],
            [['id_producto', 'id_almacen', 'num_cantidad'], 'integer'],
            [['id_almacen'], 'exist', 'skipOnError' => true, 'targetClass' => EntAlmacenes::className(), 'targetAttribute' => ['id_almacen' => 'id_almacen']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => EntProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stock' => 'Id Stock',
            'id_producto' => 'Id Producto',
            'id_almacen' => 'Id Almacen',
            'num_cantidad' => 'Num Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacen()
    {
        return $this->hasOne(EntAlmacenes::className(), ['id_almacen' => 'id_almacen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(EntProductos::className(), ['id_producto' => 'id_producto']);
    }
}
