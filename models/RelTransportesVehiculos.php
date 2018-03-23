<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_transportes_vehiculos".
 *
 * @property integer $id_vehiculo
 * @property integer $id_transporte
 * @property integer $ent_proveedores_vehiculos_id_proveedor_vehiculo
 *
 * @property EntProveedoresVehiculos $entProveedoresVehiculosIdProveedorVehiculo
 * @property EntTransportes $idTransporte
 * @property EntVehiculos $idVehiculo
 */
class RelTransportesVehiculos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_transportes_vehiculos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vehiculo', 'id_transporte', 'ent_proveedores_vehiculos_id_proveedor_vehiculo'], 'required'],
            [['id_vehiculo', 'id_transporte', 'ent_proveedores_vehiculos_id_proveedor_vehiculo'], 'integer'],
            [['ent_proveedores_vehiculos_id_proveedor_vehiculo'], 'exist', 'skipOnError' => true, 'targetClass' => EntProveedoresVehiculos::className(), 'targetAttribute' => ['ent_proveedores_vehiculos_id_proveedor_vehiculo' => 'id_proveedor_vehiculo']],
            [['id_transporte'], 'exist', 'skipOnError' => true, 'targetClass' => EntTransportes::className(), 'targetAttribute' => ['id_transporte' => 'id_transporte']],
            [['id_vehiculo'], 'exist', 'skipOnError' => true, 'targetClass' => EntVehiculos::className(), 'targetAttribute' => ['id_vehiculo' => 'id_vehiculo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vehiculo' => 'Id Vehiculo',
            'id_transporte' => 'Id Transporte',
            'ent_proveedores_vehiculos_id_proveedor_vehiculo' => 'Ent Proveedores Vehiculos Id Proveedor Vehiculo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntProveedoresVehiculosIdProveedorVehiculo()
    {
        return $this->hasOne(EntProveedoresVehiculos::className(), ['id_proveedor_vehiculo' => 'ent_proveedores_vehiculos_id_proveedor_vehiculo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTransporte()
    {
        return $this->hasOne(EntTransportes::className(), ['id_transporte' => 'id_transporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVehiculo()
    {
        return $this->hasOne(EntVehiculos::className(), ['id_vehiculo' => 'id_vehiculo']);
    }
}
