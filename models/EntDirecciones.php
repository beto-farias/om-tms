<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_direcciones".
 *
 * @property integer $id_direccion
 * @property string $uddi
 * @property string $txt_calle
 * @property string $txt_numero_exterior
 * @property string $txt_numero_interior
 * @property string $txt_colonia
 * @property string $txt_estado
 * @property string $txt_pais
 * @property string $txt_cp
 * @property string $txt_referencia
 *
 * @property EntEnvios[] $entEnvios
 * @property EntEnvios[] $entEnvios0
 */
class EntDirecciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_direcciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uddi', 'txt_calle', 'txt_numero_exterior', 'txt_colonia', 'txt_estado', 'txt_pais', 'txt_cp', 'txt_referencia'], 'required'],
            [['uddi', 'txt_calle', 'txt_numero_exterior', 'txt_numero_interior', 'txt_colonia', 'txt_estado', 'txt_pais'], 'string', 'max' => 45],
            [['txt_cp'], 'string', 'max' => 5],
            [['txt_referencia'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_direccion' => 'Id Direccion',
            'uddi' => 'Uddi',
            'txt_calle' => 'Txt Calle',
            'txt_numero_exterior' => 'Txt Numero Exterior',
            'txt_numero_interior' => 'Txt Numero Interior',
            'txt_colonia' => 'Txt Colonia',
            'txt_estado' => 'Txt Estado',
            'txt_pais' => 'Txt Pais',
            'txt_cp' => 'Txt Cp',
            'txt_referencia' => 'Txt Referencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_direccion_destino' => 'id_direccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEnvios0()
    {
        return $this->hasMany(EntEnvios::className(), ['id_direccion_remitente' => 'id_direccion']);
    }
}
