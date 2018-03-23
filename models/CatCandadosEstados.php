<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_candados_estados".
 *
 * @property integer $id_candado_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property EntCandados[] $entCandados
 * @property WrkEventosCandados[] $wrkEventosCandados
 */
class CatCandadosEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_candados_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_candado_estado' => 'Id Candado Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCandados()
    {
        return $this->hasMany(EntCandados::className(), ['id_candado_estado' => 'id_candado_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkEventosCandados()
    {
        return $this->hasMany(WrkEventosCandados::className(), ['id_candado_estado' => 'id_candado_estado']);
    }
}
