<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_atributos_productos".
 *
 * @property integer $id_atributo_producto
 * @property string $txt_nombre
 * @property integer $b_habilitado
 *
 * @property CatAtributosProductosOpciones[] $catAtributosProductosOpciones
 * @property RelProductosCatAtributos[] $relProductosCatAtributos
 * @property EntProductos[] $idProductos
 */
class CatAtributosProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_atributos_productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'id_atributo_producto' => 'Atributo',
            'txt_nombre' => 'Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatAtributosProductosOpciones()
    {
        return $this->hasMany(CatAtributosProductosOpciones::className(), ['id_atributo_producto' => 'id_atributo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelProductosCatAtributos()
    {
        return $this->hasMany(RelProductosCatAtributos::className(), ['id_atributo_producto' => 'id_atributo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductos()
    {
        return $this->hasMany(EntProductos::className(), ['id_producto' => 'id_producto'])->viaTable('rel_productos_cat_atributos', ['id_atributo_producto' => 'id_atributo_producto']);
    }
}
