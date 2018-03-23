<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_envios_atributos".
 *
 * @property integer $id_envio
 * @property integer $id_envio_atributo
 * @property string $txt_valor
 *
 * @property CatEnviosAtributos $idEnvioAtributo
 * @property EntEnvios $idEnvio
 */
class RelEnviosAtributos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_envios_atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio', 'id_envio_atributo'], 'required'],
            [['id_envio', 'id_envio_atributo'], 'integer'],
            [['txt_valor'], 'string', 'max' => 45],
            [['id_envio_atributo'], 'exist', 'skipOnError' => true, 'targetClass' => CatEnviosAtributos::className(), 'targetAttribute' => ['id_envio_atributo' => 'id_envio_atributo']],
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
            'id_envio_atributo' => 'Id Envio Atributo',
            'txt_valor' => 'Txt Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvioAtributo()
    {
        return $this->hasOne(CatEnviosAtributos::className(), ['id_envio_atributo' => 'id_envio_atributo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }
}
