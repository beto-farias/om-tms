<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_vendedores".
 *
 * @property integer $id_vendedor
 * @property integer $id_rol
 * @property integer $id_tienda
 * @property string $uddi
 * @property string $txt_nombre
 * @property string $txt_nombre_usuario
 * @property string $txt_contrasena
 * @property integer $b_activo
 *
 * @property CatRoles $idRol
 * @property EntTiendas $idTienda
 * @property RelVendedoresClientes[] $relVendedoresClientes
 * @property RelVentaVendedor[] $relVentaVendedors
 * @property WrkVentas[] $idVentas
 * @property WrkCitas[] $wrkCitas
 * @property WrkMetasVentasVendedor[] $wrkMetasVentasVendedors
 * @property WrkMetasVentas[] $idMetas
 * @property WrkVendedoresDisponibilidades[] $wrkVendedoresDisponibilidades
 * @property WrkVendedoresSesiones $wrkVendedoresSesiones
 */
class EntVendedores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_vendedores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_tienda', 'uddi'], 'required'],
            [['id_rol', 'id_tienda', 'b_activo'], 'integer'],
            [['uddi', 'txt_nombre'], 'string', 'max' => 45],
            [['txt_nombre_usuario', 'txt_contrasena'], 'string', 'max' => 8],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => CatRoles::className(), 'targetAttribute' => ['id_rol' => 'id_rol']],
            [['id_tienda'], 'exist', 'skipOnError' => true, 'targetClass' => EntTiendas::className(), 'targetAttribute' => ['id_tienda' => 'id_tienda']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor' => 'Id Vendedor',
            'id_rol' => 'Id Rol',
            'id_tienda' => 'Id Tienda',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
            'txt_nombre_usuario' => 'Txt Nombre Usuario',
            'txt_contrasena' => 'Txt Contrasena',
            'b_activo' => 'B Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRol()
    {
        return $this->hasOne(CatRoles::className(), ['id_rol' => 'id_rol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTienda()
    {
        return $this->hasOne(EntTiendas::className(), ['id_tienda' => 'id_tienda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVendedoresClientes()
    {
        return $this->hasMany(RelVendedoresClientes::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVentaVendedors()
    {
        return $this->hasMany(RelVentaVendedor::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVentas()
    {
        return $this->hasMany(WrkVentas::className(), ['id_venta' => 'id_venta'])->viaTable('rel_venta_vendedor', ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkCitas()
    {
        return $this->hasMany(WrkCitas::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkMetasVentasVendedors()
    {
        return $this->hasMany(WrkMetasVentasVendedor::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMetas()
    {
        return $this->hasMany(WrkMetasVentas::className(), ['id_meta_venta' => 'id_meta'])->viaTable('wrk_metas_ventas_vendedor', ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkVendedoresDisponibilidades()
    {
        return $this->hasMany(WrkVendedoresDisponibilidades::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkVendedoresSesiones()
    {
        return $this->hasOne(WrkVendedoresSesiones::className(), ['id_vendedor' => 'id_vendedor']);
    }
}
