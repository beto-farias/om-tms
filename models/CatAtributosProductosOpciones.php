<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_atributos_productos_opciones".
 *
 * @property string $id_atributo_producto_opcion
 * @property string $id_producto
 * @property string $id_padre
 * @property string $id_atributo_producto
 * @property string $txt_valor
 * @property integer $b_habilitado
 *
 * @property EntProductos $idProducto
 * @property CatAtributosProductosOpciones $idPadre
 * @property CatAtributosProductosOpciones[] $catAtributosProductosOpciones
 * @property CatAtributosProductos $idAtributoProducto
 * @property RelProductosCatAtributos[] $relProductosCatAtributos
 */
class CatAtributosProductosOpciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_atributos_productos_opciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto', 'txt_valor'], 'required'],
            [['id_producto', 'id_padre', 'id_atributo_producto', 'b_habilitado'], 'integer'],
            [['txt_valor'], 'string', 'max' => 200],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => EntProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
            [['id_padre'], 'exist', 'skipOnError' => true, 'targetClass' => CatAtributosProductosOpciones::className(), 'targetAttribute' => ['id_padre' => 'id_atributo_producto_opcion']],
            [['id_atributo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatAtributosProductos::className(), 'targetAttribute' => ['id_atributo_producto' => 'id_atributo_producto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_atributo_producto_opcion' => 'Id Atributo Producto Opcion',
            'id_producto' => 'Producto',
            'id_padre' => 'Atributo',
            'id_atributo_producto' => 'Atributo del producto',
            'txt_valor' => 'Valor',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(EntProductos::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPadre()
    {
        return $this->hasOne(CatAtributosProductosOpciones::className(), ['id_atributo_producto_opcion' => 'id_padre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatAtributosProductosOpciones()
    {
        return $this->hasMany(CatAtributosProductosOpciones::className(), ['id_padre' => 'id_atributo_producto_opcion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAtributoProducto()
    {
        return $this->hasOne(CatAtributosProductos::className(), ['id_atributo_producto' => 'id_atributo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelProductosCatAtributos()
    {
        return $this->hasMany(RelProductosCatAtributos::className(), ['id_atributo_producto_opcion' => 'id_atributo_producto_opcion']);
    }
}
