<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_tiendas".
 *
 * @property integer $id_tienda
 * @property string $uddi
 * @property string $txt_nombre
 * @property string $txt_direccion
 * @property double $num_lat
 * @property double $num_lon
 * @property string $txt_telefono
 * @property string $txt_correo
 * @property integer $b_habilitado
 *
 * @property EntVendedores[] $entVendedores
 * @property WrkVentas[] $wrkVentas
 */
class EntTiendas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_tiendas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uddi', 'txt_nombre', 'b_habilitado'], 'required'],
            [['num_lat', 'num_lon'], 'number'],
            [['b_habilitado'], 'integer'],
            [['uddi', 'txt_nombre', 'txt_correo'], 'string', 'max' => 45],
            [['txt_direccion'], 'string', 'max' => 200],
            [['txt_telefono'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tienda' => 'Id Tienda',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
            'txt_direccion' => 'Txt Direccion',
            'num_lat' => 'Num Lat',
            'num_lon' => 'Num Lon',
            'txt_telefono' => 'Txt Telefono',
            'txt_correo' => 'Txt Correo',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntVendedores()
    {
        return $this->hasMany(EntVendedores::className(), ['id_tienda' => 'id_tienda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkVentas()
    {
        return $this->hasMany(WrkVentas::className(), ['id_tienda' => 'id_tienda']);
    }
}
