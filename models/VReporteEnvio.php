<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_reporte_envio".
 *
 * @property integer $id_evento
 * @property integer $id_envio
 * @property integer $id_consolidado
 * @property integer $id_almacen
 * @property string $txt_lugar
 * @property string $fch_evento
 * @property string $txt_notas
 * @property string $txt_evento
 */
class VReporteEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_reporte_envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evento', 'id_envio', 'id_consolidado', 'id_almacen'], 'integer'],
            [['fch_evento'], 'safe'],
            [['txt_lugar', 'txt_evento'], 'string', 'max' => 45],
            [['txt_notas'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'id_envio' => 'Id Envio',
            'id_consolidado' => 'Id Consolidado',
            'id_almacen' => 'Id Almacen',
            'txt_lugar' => 'Txt Lugar',
            'fch_evento' => 'Fch Evento',
            'txt_notas' => 'Txt Notas',
            'txt_evento' => 'Txt Evento',
        ];
    }
}
