<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_fabricantes".
 *
 * @property integer $id_fabricante
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property integer $b_habilitado
 *
 * @property CatMarcasProductos[] $catMarcasProductos
 */
class CatFabricantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_fabricantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_clave'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_clave'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_fabricante' => 'Id Fabricante',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatMarcasProductos()
    {
        return $this->hasMany(CatMarcasProductos::className(), ['id_fabricante' => 'id_fabricante']);
    }
}
