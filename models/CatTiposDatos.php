<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_datos".
 *
 * @property integer $id_tipo_dato
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property CatEnviosAtributos[] $catEnviosAtributos
 */
class CatTiposDatos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_datos';
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
            'id_tipo_dato' => 'Id Tipo Dato',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatEnviosAtributos()
    {
        return $this->hasMany(CatEnviosAtributos::className(), ['id_tipo_dato' => 'id_tipo_dato']);
    }
}
