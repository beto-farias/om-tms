<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_metas_ventas".
 *
 * @property integer $id_meta_venta
 * @property integer $num_mes
 * @property integer $num_anio
 * @property integer $num_meta
 * @property integer $num_porcentaje
 *
 * @property WrkMetasVentasVendedor[] $wrkMetasVentasVendedors
 * @property EntVendedores[] $idVendedors
 */
class WrkMetasVentas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_metas_ventas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_mes', 'num_anio', 'num_meta', 'num_porcentaje'], 'required'],
            [['num_mes', 'num_anio', 'num_meta', 'num_porcentaje'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_meta_venta' => 'Id Meta Venta',
            'num_mes' => 'Num Mes',
            'num_anio' => 'Num Anio',
            'num_meta' => 'Num Meta',
            'num_porcentaje' => 'Num Porcentaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkMetasVentasVendedors()
    {
        return $this->hasMany(WrkMetasVentasVendedor::className(), ['id_meta' => 'id_meta_venta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedors()
    {
        return $this->hasMany(EntVendedores::className(), ['id_vendedor' => 'id_vendedor'])->viaTable('wrk_metas_ventas_vendedor', ['id_meta' => 'id_meta_venta']);
    }
}
