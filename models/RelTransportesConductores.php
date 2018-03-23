<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_transportes_conductores".
 *
 * @property integer $id_conductor
 * @property integer $id_transporte
 *
 * @property EntConductores $idConductor
 * @property EntTransportes $idTransporte
 */
class RelTransportesConductores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_transportes_conductores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_conductor', 'id_transporte'], 'required'],
            [['id_conductor', 'id_transporte'], 'integer'],
            [['id_conductor'], 'exist', 'skipOnError' => true, 'targetClass' => EntConductores::className(), 'targetAttribute' => ['id_conductor' => 'id_conductor']],
            [['id_transporte'], 'exist', 'skipOnError' => true, 'targetClass' => EntTransportes::className(), 'targetAttribute' => ['id_transporte' => 'id_transporte']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_conductor' => 'Id Conductor',
            'id_transporte' => 'Id Transporte',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConductor()
    {
        return $this->hasOne(EntConductores::className(), ['id_conductor' => 'id_conductor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTransporte()
    {
        return $this->hasOne(EntTransportes::className(), ['id_transporte' => 'id_transporte']);
    }
}
