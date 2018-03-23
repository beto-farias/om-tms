<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_proveedores_vehiculos".
 *
 * @property integer $id_proveedor_vehiculo
 * @property string $txt_nombre
 * @property string $txt_telefono_contacto
 * @property string $txt_correo_contacto
 * @property string $fch_registro
 * @property integer $b_habilitado
 * @property string $txt_notas
 *
 * @property RelTransportesVehiculos[] $relTransportesVehiculos
 */
class EntProveedoresVehiculos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_proveedores_vehiculos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_telefono_contacto', 'txt_correo_contacto'], 'required'],
            [['fch_registro'], 'safe'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_telefono_contacto', 'txt_correo_contacto'], 'string', 'max' => 45],
            [['txt_notas'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_proveedor_vehiculo' => 'Id Proveedor Vehiculo',
            'txt_nombre' => 'Txt Nombre',
            'txt_telefono_contacto' => 'Txt Telefono Contacto',
            'txt_correo_contacto' => 'Txt Correo Contacto',
            'fch_registro' => 'Fch Registro',
            'b_habilitado' => 'B Habilitado',
            'txt_notas' => 'Txt Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransportesVehiculos()
    {
        return $this->hasMany(RelTransportesVehiculos::className(), ['ent_proveedores_vehiculos_id_proveedor_vehiculo' => 'id_proveedor_vehiculo']);
    }
}
