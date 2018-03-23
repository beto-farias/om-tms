<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_dias_semanas".
 *
 * @property integer $id_dia_semana
 * @property string $txt_nombre
 * @property integer $b_habilitado
 *
 * @property WrkVendedoresDisponibilidades[] $wrkVendedoresDisponibilidades
 */
class CatDiasSemanas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_dias_semanas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'b_habilitado'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dia_semana' => 'Id Dia Semana',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkVendedoresDisponibilidades()
    {
        return $this->hasMany(WrkVendedoresDisponibilidades::className(), ['id_dia_semana' => 'id_dia_semana']);
    }
}
