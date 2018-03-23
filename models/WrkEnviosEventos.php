<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_envios_eventos".
 *
 * @property integer $id_envio_evento
 * @property integer $id_envio
 * @property integer $id_envio_estado
 * @property string $fch_evento
 * @property string $txt_notas
 *
 * @property CatEnviosEstados $idEnvioEstado
 * @property EntEnvios $idEnvio
 */
class WrkEnviosEventos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_envios_eventos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio', 'id_envio_estado'], 'required'],
            [['id_envio', 'id_envio_estado'], 'integer'],
            [['fch_evento'], 'safe'],
            [['txt_notas'], 'string', 'max' => 100],
            [['id_envio_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatEnviosEstados::className(), 'targetAttribute' => ['id_envio_estado' => 'id_envio_estado']],
            [['id_envio'], 'exist', 'skipOnError' => true, 'targetClass' => EntEnvios::className(), 'targetAttribute' => ['id_envio' => 'id_envio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio_evento' => 'Id Envio Evento',
            'id_envio' => 'Id Envio',
            'id_envio_estado' => 'Id Envio Estado',
            'fch_evento' => 'Fch Evento',
            'txt_notas' => 'Txt Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvioEstado()
    {
        return $this->hasOne(CatEnviosEstados::className(), ['id_envio_estado' => 'id_envio_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }
}
