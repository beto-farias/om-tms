<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_transportes".
 *
 * @property integer $id_transporte
 * @property string $uddi
 * @property integer $id_consolidado
 *
 * @property EntConsolidados $idConsolidado
 * @property RelTransportesConductores[] $relTransportesConductores
 * @property EntConductores[] $idConductors
 * @property RelTransportesVehiculos[] $relTransportesVehiculos
 */
class EntTransportes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_transportes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_transporte'], 'required'],
            [['id_transporte', 'id_consolidado'], 'integer'],
            [['uddi'], 'string', 'max' => 45],
            [['id_consolidado'], 'exist', 'skipOnError' => true, 'targetClass' => EntConsolidados::className(), 'targetAttribute' => ['id_consolidado' => 'id_consolidado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transporte' => 'Id Transporte',
            'uddi' => 'Uddi',
            'id_consolidado' => 'Id Consolidado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidado()
    {
        return $this->hasOne(EntConsolidados::className(), ['id_consolidado' => 'id_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransportesConductores()
    {
        return $this->hasMany(RelTransportesConductores::className(), ['id_transporte' => 'id_transporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConductors()
    {
        return $this->hasMany(EntConductores::className(), ['id_conductor' => 'id_conductor'])->viaTable('rel_transportes_conductores', ['id_transporte' => 'id_transporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransportesVehiculos()
    {
        return $this->hasMany(RelTransportesVehiculos::className(), ['id_transporte' => 'id_transporte']);
    }
}
