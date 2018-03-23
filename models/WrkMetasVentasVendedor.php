<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_metas_ventas_vendedor".
 *
 * @property integer $id_vendedor
 * @property integer $id_meta
 * @property integer $num_meta
 * @property integer $num_porcentaje
 *
 * @property EntVendedores $idVendedor
 * @property WrkMetasVentas $idMeta
 */
class WrkMetasVentasVendedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_metas_ventas_vendedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_meta', 'num_meta', 'num_porcentaje'], 'required'],
            [['id_vendedor', 'id_meta', 'num_meta', 'num_porcentaje'], 'integer'],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
            [['id_meta'], 'exist', 'skipOnError' => true, 'targetClass' => WrkMetasVentas::className(), 'targetAttribute' => ['id_meta' => 'id_meta_venta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor' => 'Id Vendedor',
            'id_meta' => 'Id Meta',
            'num_meta' => 'Num Meta',
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
    public function getIdMeta()
    {
        return $this->hasOne(WrkMetasVentas::className(), ['id_meta_venta' => 'id_meta']);
    }
}
