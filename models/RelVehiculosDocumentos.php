<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_vehiculos_documentos".
 *
 * @property integer $id_rel_vehiculo_documento
 * @property integer $id_vehiculo
 * @property integer $id_documento
 * @property integer $b_actual
 * @property string $fch_registro
 * @property string $fch_vencimiento
 * @property integer $b_tiene_vigencia
 * @property string $txt_url
 *
 * @property CatDocumentos $idDocumento
 * @property EntVehiculos $idVehiculo
 */
class RelVehiculosDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_vehiculos_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vehiculo', 'id_documento'], 'required'],
            [['id_vehiculo', 'id_documento', 'b_actual', 'b_tiene_vigencia'], 'integer'],
            [['fch_registro', 'fch_vencimiento'], 'safe'],
            [['txt_url'], 'string', 'max' => 45],
            [['id_documento'], 'exist', 'skipOnError' => true, 'targetClass' => CatDocumentos::className(), 'targetAttribute' => ['id_documento' => 'id_documento']],
            [['id_vehiculo'], 'exist', 'skipOnError' => true, 'targetClass' => EntVehiculos::className(), 'targetAttribute' => ['id_vehiculo' => 'id_vehiculo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rel_vehiculo_documento' => 'Id Rel Vehiculo Documento',
            'id_vehiculo' => 'Id Vehiculo',
            'id_documento' => 'Id Documento',
            'b_actual' => 'B Actual',
            'fch_registro' => 'Fch Registro',
            'fch_vencimiento' => 'Fch Vencimiento',
            'b_tiene_vigencia' => 'B Tiene Vigencia',
            'txt_url' => 'Txt Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDocumento()
    {
        return $this->hasOne(CatDocumentos::className(), ['id_documento' => 'id_documento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVehiculo()
    {
        return $this->hasOne(EntVehiculos::className(), ['id_vehiculo' => 'id_vehiculo']);
    }
}
