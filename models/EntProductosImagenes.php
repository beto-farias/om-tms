<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_productos_imagenes".
 *
 * @property integer $id_producto_imagen
 * @property integer $id_producto
 * @property string $txt_url_imagen
 * @property integer $b_habilitado
 *
 * @property EntProductos $idProducto
 */
class EntProductosImagenes extends \yii\db\ActiveRecord
{
    public $imagen;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_productos_imagenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                        'imagen'
                ],
                'image',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg, jpeg',
                'message' => 'Cargar imagen antes de guardar'
            ],
            [['id_producto', 'txt_url_imagen'], 'required'],
            [['imagen'], 'required', 'message' => 'Cargar imagen antes de guardar'],
            [['id_producto', 'b_habilitado'], 'integer'],
            [['txt_url_imagen'], 'string', 'max' => 100],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => EntProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_producto_imagen' => 'Id Producto Imagen',
            'id_producto' => 'Id Producto',
            'txt_url_imagen' => 'Txt Url Imagen',
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
}
