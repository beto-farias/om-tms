<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_consolidados".
 *
 * @property integer $id_consolidado
 * @property integer $id_tipo_consolidado
 * @property string $uddi
 * @property string $txt_nombre
 * @property string $fch_creacion
 * @property integer $id_almacen_origen
 * @property integer $id_almacen_destino
 * @property integer $id_consolidado_estado
 *
 * @property CatConsolidadosEstados $idConsolidadoEstado
 * @property CatTiposConsolidados $idTipoConsolidado
 * @property EntAlmacenes $idAlmacenOrigen
 * @property EntAlmacenes $idAlmacenDestino
 * @property EntTransportes[] $entTransportes
 * @property RelEnviosConsolidados[] $relEnviosConsolidados
 * @property EntEnvios[] $idEnvios
 * @property WrkConsolidadosEventos[] $wrkConsolidadosEventos
 */
class EntConsolidados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_consolidados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_consolidado', 'txt_nombre', 'id_almacen_origen', 'id_almacen_destino', 'id_consolidado_estado'], 'required'],
            [['id_tipo_consolidado', 'id_almacen_origen', 'id_almacen_destino', 'id_consolidado_estado'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['uddi', 'txt_nombre'], 'string', 'max' => 45],
            [['id_consolidado_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatConsolidadosEstados::className(), 'targetAttribute' => ['id_consolidado_estado' => 'id_consolidado_estado']],
            [['id_tipo_consolidado'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposConsolidados::className(), 'targetAttribute' => ['id_tipo_consolidado' => 'id_tipo_consolidado']],
            [['id_almacen_origen'], 'exist', 'skipOnError' => true, 'targetClass' => EntAlmacenes::className(), 'targetAttribute' => ['id_almacen_origen' => 'id_almacen']],
            [['id_almacen_destino'], 'exist', 'skipOnError' => true, 'targetClass' => EntAlmacenes::className(), 'targetAttribute' => ['id_almacen_destino' => 'id_almacen']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_consolidado' => 'Id Consolidado',
            'id_tipo_consolidado' => 'Id Tipo Consolidado',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
            'fch_creacion' => 'Fch Creacion',
            'id_almacen_origen' => 'Id Almacen Origen',
            'id_almacen_destino' => 'Id Almacen Destino',
            'id_consolidado_estado' => 'Id Consolidado Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidadoEstado()
    {
        return $this->hasOne(CatConsolidadosEstados::className(), ['id_consolidado_estado' => 'id_consolidado_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoConsolidado()
    {
        return $this->hasOne(CatTiposConsolidados::className(), ['id_tipo_consolidado' => 'id_tipo_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacenOrigen()
    {
        return $this->hasOne(EntAlmacenes::className(), ['id_almacen' => 'id_almacen_origen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacenDestino()
    {
        return $this->hasOne(EntAlmacenes::className(), ['id_almacen' => 'id_almacen_destino']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntTransportes()
    {
        return $this->hasMany(EntTransportes::className(), ['id_consolidado' => 'id_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosConsolidados()
    {
        return $this->hasMany(RelEnviosConsolidados::className(), ['id_consolidado' => 'id_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_envio' => 'id_envio'])->viaTable('rel_envios_consolidados', ['id_consolidado' => 'id_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkConsolidadosEventos()
    {
        return $this->hasMany(WrkConsolidadosEventos::className(), ['id_consolidado' => 'id_consolidado']);
    }
}