<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_marcas_productos".
 *
 * @property integer $id_marca_producto
 * @property integer $id_fabricante
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property integer $b_habilitado
 *
 * @property CatFabricantes $idFabricante
 * @property EntProductos[] $entProductos
 */
class CatMarcasProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_marcas_productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fabricante', 'txt_nombre', 'txt_clave'], 'required'],
            [['id_fabricante', 'b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_clave'], 'string', 'max' => 5],
            [['id_fabricante'], 'exist', 'skipOnError' => true, 'targetClass' => CatFabricantes::className(), 'targetAttribute' => ['id_fabricante' => 'id_fabricante']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_marca_producto' => 'Id Marca Producto',
            'id_fabricante' => 'Id Fabricante',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFabricante()
    {
        return $this->hasOne(CatFabricantes::className(), ['id_fabricante' => 'id_fabricante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntProductos()
    {
        return $this->hasMany(EntProductos::className(), ['id_marca_producto' => 'id_marca_producto']);
    }
}
