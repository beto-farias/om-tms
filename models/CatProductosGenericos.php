<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_productos_genericos".
 *
 * @property integer $id_producto_generico
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property string $txt_img
 * @property integer $b_habilitado
 *
 * @property EntProductos[] $entProductos
 */
class CatProductosGenericos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_productos_genericos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto_generico', 'txt_nombre', 'txt_clave'], 'required'],
            [['id_producto_generico', 'b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_img'], 'string', 'max' => 45],
            [['txt_clave'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_producto_generico' => 'Id Producto Generico',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'txt_img' => 'Txt Img',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntProductos()
    {
        return $this->hasMany(EntProductos::className(), ['id_producto_generico' => 'id_producto_generico']);
    }
}
