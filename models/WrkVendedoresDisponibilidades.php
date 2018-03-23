<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_vendedores_disponibilidades".
 *
 * @property integer $id_vendedor
 * @property integer $id_dia_semana
 * @property integer $num_hora_disponible
 * @property string $txt_notas
 *
 * @property CatDiasSemanas $idDiaSemana
 * @property EntVendedores $idVendedor
 */
class WrkVendedoresDisponibilidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_vendedores_disponibilidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_dia_semana', 'num_hora_disponible'], 'required'],
            [['id_vendedor', 'id_dia_semana', 'num_hora_disponible'], 'integer'],
            [['txt_notas'], 'string', 'max' => 200],
            [['id_dia_semana'], 'exist', 'skipOnError' => true, 'targetClass' => CatDiasSemanas::className(), 'targetAttribute' => ['id_dia_semana' => 'id_dia_semana']],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDiaSemana()
    {
        return $this->hasOne(CatDiasSemanas::className(), ['id_dia_semana' => 'id_dia_semana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedor()
    {
        return $this->hasOne(EntVendedores::className(), ['id_vendedor' => 'id_vendedor']);
    }
}
