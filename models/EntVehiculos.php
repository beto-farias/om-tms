<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_vehiculos".
 *
 * @property integer $id_vehiculo
 * @property string $uddi
 *
 * @property RelTransportesVehiculos[] $relTransportesVehiculos
 * @property RelVehiculosDocumentos[] $relVehiculosDocumentos
 */
class EntVehiculos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_vehiculos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uddi'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vehiculo' => 'Id Vehiculo',
            'uddi' => 'Uddi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransportesVehiculos()
    {
        return $this->hasMany(RelTransportesVehiculos::className(), ['id_vehiculo' => 'id_vehiculo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVehiculosDocumentos()
    {
        return $this->hasMany(RelVehiculosDocumentos::className(), ['id_vehiculo' => 'id_vehiculo']);
    }
}
