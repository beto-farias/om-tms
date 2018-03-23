<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_disponibilidades_vendedores_citas".
 *
 * @property integer $id_vendedor
 * @property integer $id_dia_semana
 * @property integer $num_hora_disponible
 * @property string $txt_notas
 * @property integer $id_cita
 * @property integer $num_semana
 */
class VDisponibilidadesVendedoresCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_disponibilidades_vendedores_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_dia_semana', 'num_hora_disponible'], 'required'],
            [['id_vendedor', 'id_dia_semana', 'num_hora_disponible', 'id_cita', 'num_semana'], 'integer'],
            [['txt_notas'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor' => 'Id Vendedor',
            'id_dia_semana' => 'Id Dia Semana',
            'num_hora_disponible' => 'Num Hora Disponible',
            'txt_notas' => 'Txt Notas',
            'id_cita' => 'Id Cita',
            'num_semana' => 'Num Semana',
        ];
    }
}
