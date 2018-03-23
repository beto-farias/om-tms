<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_conductores_documentos".
 *
 * @property integer $id_rel_conductor_documento
 * @property integer $id_conductor
 * @property integer $id_documento
 * @property integer $b_actual
 * @property string $fch_registro
 * @property string $fch_vencimiento
 * @property integer $b_tiene_vigencia
 * @property string $txt_url
 *
 * @property CatDocumentos $idDocumento
 * @property EntConductores $idConductor
 */
class RelConductoresDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_conductores_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_conductor', 'id_documento'], 'required'],
            [['id_conductor', 'id_documento', 'b_actual', 'b_tiene_vigencia'], 'integer'],
            [['fch_registro', 'fch_vencimiento'], 'safe'],
            [['txt_url'], 'string', 'max' => 45],
            [['id_documento'], 'exist', 'skipOnError' => true, 'targetClass' => CatDocumentos::className(), 'targetAttribute' => ['id_documento' => 'id_documento']],
            [['id_conductor'], 'exist', 'skipOnError' => true, 'targetClass' => EntConductores::className(), 'targetAttribute' => ['id_conductor' => 'id_conductor']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rel_conductor_documento' => 'Id Rel Conductor Documento',
            'id_conductor' => 'Id Conductor',
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
    public function getIdConductor()
    {
        return $this->hasOne(EntConductores::className(), ['id_conductor' => 'id_conductor']);
    }
}
