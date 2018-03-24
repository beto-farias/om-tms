<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_clientes".
 *
 * @property integer $id_cliente
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilotado
 *
 * @property EntPlataformas[] $entPlataformas
 */
class EntClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilotado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilotado' => 'B Habilotado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPlataformas()
    {
        return $this->hasMany(EntPlataformas::className(), ['id_cliente' => 'id_cliente']);
    }
}
