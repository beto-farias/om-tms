<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_grupos_productos".
 *
 * @property integer $id_grupo_producto
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property integer $b_habilitado
 *
 * @property EntProductos[] $entProductos
 */
class CatGruposProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_grupos_productos';
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
            'id_grupo_producto' => 'Id Grupo Producto',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntProductos()
    {
        return $this->hasMany(EntProductos::className(), ['id_grupo_producto' => 'id_grupo_producto']);
    }
}
