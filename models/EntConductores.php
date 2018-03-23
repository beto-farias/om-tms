<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_conductores".
 *
 * @property integer $id_conductor
 * @property string $uddi
 *
 * @property RelConductoresDocumentos[] $relConductoresDocumentos
 * @property RelTransportesConductores[] $relTransportesConductores
 * @property EntTransportes[] $idTransportes
 */
class EntConductores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_conductores';
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
            'id_conductor' => 'Id Conductor',
            'uddi' => 'Uddi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelConductoresDocumentos()
    {
        return $this->hasMany(RelConductoresDocumentos::className(), ['id_conductor' => 'id_conductor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransportesConductores()
    {
        return $this->hasMany(RelTransportesConductores::className(), ['id_conductor' => 'id_conductor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTransportes()
    {
        return $this->hasMany(EntTransportes::className(), ['id_transporte' => 'id_transporte'])->viaTable('rel_transportes_conductores', ['id_conductor' => 'id_conductor']);
    }
}
