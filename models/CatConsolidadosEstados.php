<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_consolidados_estados".
 *
 * @property integer $id_consolidado_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property WrkConsolidadosEventos[] $wrkConsolidadosEventos
 */
class CatConsolidadosEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_consolidados_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_consolidado_estado' => 'Id Consolidado Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkConsolidadosEventos()
    {
        return $this->hasMany(WrkConsolidadosEventos::className(), ['id_consolidado_estado' => 'id_consolidado_estado']);
    }
}
