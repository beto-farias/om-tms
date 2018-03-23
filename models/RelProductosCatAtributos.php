<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_productos_cat_atributos".
 *
 * @property integer $id_producto
 * @property integer $id_atributo_producto
 * @property string $txt_valor
 * @property integer $id_atributo_producto_opcion
 *
 * @property CatAtributosProductos $idAtributoProducto
 * @property CatAtributosProductosOpciones $idAtributoProductoOpcion
 * @property EntProductos $idProducto
 */
class RelProductosCatAtributos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_productos_cat_atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto', 'id_atributo_producto'], 'required'],
            [['id_producto', 'id_atributo_producto', 'id_atributo_producto_opcion'], 'integer'],
            [['txt_valor'], 'string', 'max' => 45],
            [['id_atributo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatAtributosProductos::className(), 'targetAttribute' => ['id_atributo_producto' => 'id_atributo_producto']],
            [['id_atributo_producto_opcion'], 'exist', 'skipOnError' => true, 'targetClass' => CatAtributosProductosOpciones::className(), 'targetAttribute' => ['id_atributo_producto_opcion' => 'id_atributo_producto_opcion']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => EntProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_producto' => 'Id Producto',
            'id_atributo_producto' => 'Id Atributo Producto',
            'txt_valor' => 'Txt Valor',
            'id_atributo_producto_opcion' => 'Id Atributo Producto Opcion',
        ];
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
    public function getIdAtributoProductoOpcion()
    {
        return $this->hasOne(CatAtributosProductosOpciones::className(), ['id_atributo_producto_opcion' => 'id_atributo_producto_opcion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(EntProductos::className(), ['id_producto' => 'id_producto']);
    }
}
