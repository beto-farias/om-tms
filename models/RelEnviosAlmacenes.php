<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_envios_almacenes".
 *
 * @property integer $id_envio
 * @property integer $id_almacen
 * @property integer $b_perdido
 *
 * @property EntAlmacenes $idAlmacen
 * @property EntEnvios $idEnvio
 * @property WrkAlmacenesEventos[] $wrkAlmacenesEventos
 */
class RelEnviosAlmacenes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_envios_almacenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio', 'id_almacen'], 'required'],
            [['id_envio', 'id_almacen', 'b_perdido'], 'integer'],
            [['id_almacen'], 'exist', 'skipOnError' => true, 'targetClass' => EntAlmacenes::className(), 'targetAttribute' => ['id_almacen' => 'id_almacen']],
            [['id_envio'], 'exist', 'skipOnError' => true, 'targetClass' => EntEnvios::className(), 'targetAttribute' => ['id_envio' => 'id_envio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio' => 'Id Envio',
            'id_almacen' => 'Id Almacen',
            'b_perdido' => 'B Perdido',
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
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkAlmacenesEventos()
    {
        return $this->hasMany(WrkAlmacenesEventos::className(), ['id_envio' => 'id_envio', 'id_almacen' => 'id_almacen']);
    }
}
