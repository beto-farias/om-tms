<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_almacenes_eventos".
 *
 * @property integer $id_almacen_evento
 * @property integer $id_envio
 * @property integer $id_almacen
 * @property integer $id_almacen_estado
 * @property string $fch_evento
 * @property string $txt_notas
 *
 * @property CatAlmacenesEstados $idAlmacenEstado
 * @property RelEnviosAlmacenes $idEnvio
 */
class WrkAlmacenesEventos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_almacenes_eventos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio', 'id_almacen', 'id_almacen_estado'], 'required'],
            [['id_envio', 'id_almacen', 'id_almacen_estado'], 'integer'],
            [['fch_evento'], 'safe'],
            [['txt_notas'], 'string', 'max' => 100],
            [['id_almacen_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatAlmacenesEstados::className(), 'targetAttribute' => ['id_almacen_estado' => 'id_almacen_estado']],
            [['id_envio', 'id_almacen'], 'exist', 'skipOnError' => true, 'targetClass' => RelEnviosAlmacenes::className(), 'targetAttribute' => ['id_envio' => 'id_envio', 'id_almacen' => 'id_almacen']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_almacen_evento' => 'Id Almacen Evento',
            'id_envio' => 'Id Envio',
            'id_almacen' => 'Id Almacen',
            'id_almacen_estado' => 'Id Almacen Estado',
            'fch_evento' => 'Fch Evento',
            'txt_notas' => 'Txt Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacenEstado()
    {
        return $this->hasOne(CatAlmacenesEstados::className(), ['id_almacen_estado' => 'id_almacen_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvio()
    {
        return $this->hasOne(RelEnviosAlmacenes::className(), ['id_envio' => 'id_envio', 'id_almacen' => 'id_almacen']);
    }
}
