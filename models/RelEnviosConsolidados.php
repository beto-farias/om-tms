<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_envios_consolidados".
 *
 * @property integer $id_envio
 * @property integer $id_consolidado
 * @property string $fch_asignacion
 *
 * @property EntConsolidados $idConsolidado
 * @property EntEnvios $idEnvio
 */
class RelEnviosConsolidados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_envios_consolidados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio', 'id_consolidado'], 'required'],
            [['id_envio', 'id_consolidado'], 'integer'],
            [['fch_asignacion'], 'safe'],
            [['id_consolidado'], 'exist', 'skipOnError' => true, 'targetClass' => EntConsolidados::className(), 'targetAttribute' => ['id_consolidado' => 'id_consolidado']],
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
            'id_consolidado' => 'Id Consolidado',
            'fch_asignacion' => 'Fch Asignacion',
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
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }
}
