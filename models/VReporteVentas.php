<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_reporte_ventas".
 *
 * @property integer $id_vendedor
 * @property integer $num_porcentaje
 * @property integer $id_venta
 * @property string $fch_venta
 * @property integer $num_anio
 * @property integer $num_mes
 * @property string $num_monto_total_venta
 * @property string $num_total_producto
 * @property string $num_monto_venta_vendedor
 */
class VReporteVentas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_reporte_ventas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'num_porcentaje'], 'required'],
            [['id_vendedor', 'num_porcentaje', 'id_venta', 'num_anio', 'num_mes'], 'integer'],
            [['fch_venta'], 'safe'],
            [['num_monto_total_venta', 'num_total_producto', 'num_monto_venta_vendedor'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor' => 'Id Vendedor',
            'num_porcentaje' => 'Num Porcentaje',
            'id_venta' => 'Id Venta',
            'fch_venta' => 'Fch Venta',
            'num_anio' => 'Num Anio',
            'num_mes' => 'Num Mes',
            'num_monto_total_venta' => 'Num Monto Total Venta',
            'num_total_producto' => 'Num Total Producto',
            'num_monto_venta_vendedor' => 'Num Monto Venta Vendedor',
        ];
    }
}
