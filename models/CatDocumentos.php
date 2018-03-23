<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_documentos".
 *
 * @property integer $id_documento
 * @property string $txt_nombre
 * @property integer $b_vehiculo
 * @property integer $b_conductor
 *
 * @property RelConductoresDocumentos[] $relConductoresDocumentos
 * @property RelVehiculosDocumentos[] $relVehiculosDocumentos
 */
class CatDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_vehiculo', 'b_conductor'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_documento' => 'Id Documento',
            'txt_nombre' => 'Txt Nombre',
            'b_vehiculo' => 'B Vehiculo',
            'b_conductor' => 'B Conductor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelConductoresDocumentos()
    {
        return $this->hasMany(RelConductoresDocumentos::className(), ['id_documento' => 'id_documento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVehiculosDocumentos()
    {
        return $this->hasMany(RelVehiculosDocumentos::className(), ['id_documento' => 'id_documento']);
    }
}
