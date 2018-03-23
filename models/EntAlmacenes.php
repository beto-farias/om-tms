<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_almacenes".
 *
 * @property integer $id_almacen
 * @property string $uddi
 * @property string $txt_nombre
 *
 * @property RelEnviosAlmacenes[] $relEnviosAlmacenes
 * @property EntEnvios[] $idEnvios
 */
class EntAlmacenes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_almacenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uddi', 'txt_nombre'], 'required'],
            [['uddi', 'txt_nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_almacen' => 'Id Almacen',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosAlmacenes()
    {
        return $this->hasMany(RelEnviosAlmacenes::className(), ['id_almacen' => 'id_almacen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_envio' => 'id_envio'])->viaTable('rel_envios_almacenes', ['id_almacen' => 'id_almacen']);
    }
}
