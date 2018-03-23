<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_productos".
 *
 * @property integer $id_producto
 * @property integer $id_categoria_producto
 * @property integer $id_grupo_producto
 * @property integer $id_marca_producto
 * @property integer $id_producto_generico
 * @property string $uddi
 * @property string $txt_sku
 * @property string $txt_nombre
 * @property string $txt_description
 * @property integer $num_precio
 * @property integer $b_atributos
 * @property integer $num_tamanio_paquete
 * @property integer $b_habilitado
 *
 * @property CatCategoriasProductos $idCategoriaProducto
 * @property CatGruposProductos $idGrupoProducto
 * @property CatMarcasProductos $idMarcaProducto
 * @property CatProductosGenericos $idProductoGenerico
 * @property EntProductosImagenes[] $entProductosImagenes
 * @property RelProductosCatAtributos[] $relProductosCatAtributos
 * @property CatAtributosProductos[] $idAtributoProductos
 * @property RelVentaProducto[] $relVentaProductos
 * @property WrkVentas[] $idVentas
 * @property WrkStock[] $wrkStocks
 */
class EntProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria_producto', 'id_grupo_producto', 'id_marca_producto', 'id_producto_generico', 'uddi', 'txt_sku', 'txt_nombre', 'txt_description', 'num_precio'], 'required', 'message' => 'Este campo es requerido'],
            [['id_categoria_producto', 'id_grupo_producto', 'id_marca_producto', 'id_producto_generico', 'num_precio', 'b_atributos', 'num_tamanio_paquete', 'b_habilitado'], 'integer'],
            [['txt_description'], 'string'],
            [['uddi', 'txt_sku', 'txt_nombre'], 'string', 'max' => 100],
            [['txt_sku'], 'unique'],
            [['uddi'], 'unique'],
            [['id_categoria_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatCategoriasProductos::className(), 'targetAttribute' => ['id_categoria_producto' => 'id_categoria_producto']],
            [['id_grupo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatGruposProductos::className(), 'targetAttribute' => ['id_grupo_producto' => 'id_grupo_producto']],
            [['id_marca_producto'], 'exist', 'skipOnError' => true, 'targetClass' => CatMarcasProductos::className(), 'targetAttribute' => ['id_marca_producto' => 'id_marca_producto']],
            [['id_producto_generico'], 'exist', 'skipOnError' => true, 'targetClass' => CatProductosGenericos::className(), 'targetAttribute' => ['id_producto_generico' => 'id_producto_generico']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_producto' => 'Id Producto',
            'id_categoria_producto' => 'Categoria del producto',
            'id_grupo_producto' => 'Grupo del producto',
            'id_marca_producto' => 'Marca del producto',
            'id_producto_generico' => 'Producto generico',
            'uddi' => 'Uddi',
            'txt_sku' => 'Sku',
            'txt_nombre' => 'Nombre',
            'txt_description' => 'Description',
            'num_precio' => 'Precio',
            'b_atributos' => 'Atributos',
            'num_tamanio_paquete' => 'Tamaño Paquete',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoriaProducto()
    {
        return $this->hasOne(CatCategoriasProductos::className(), ['id_categoria_producto' => 'id_categoria_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupoProducto()
    {
        return $this->hasOne(CatGruposProductos::className(), ['id_grupo_producto' => 'id_grupo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMarcaProducto()
    {
        return $this->hasOne(CatMarcasProductos::className(), ['id_marca_producto' => 'id_marca_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductoGenerico()
    {
        return $this->hasOne(CatProductosGenericos::className(), ['id_producto_generico' => 'id_producto_generico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntProductosImagenes()
    {
        return $this->hasMany(EntProductosImagenes::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelProductosCatAtributos()
    {
        return $this->hasMany(RelProductosCatAtributos::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAtributoProductos()
    {
        return $this->hasMany(CatAtributosProductos::className(), ['id_atributo_producto' => 'id_atributo_producto'])->viaTable('rel_productos_cat_atributos', ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVentaProductos()
    {
        return $this->hasMany(RelVentaProducto::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVentas()
    {
        return $this->hasMany(WrkVentas::className(), ['id_venta' => 'id_venta'])->viaTable('rel_venta_producto', ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkStocks()
    {
        return $this->hasMany(WrkStock::className(), ['id_producto' => 'id_producto']);
    }
}
