<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_envios".
 *
 * @property integer $id_envio
 * @property string $uddi
 * @property integer $id_envio_estado
 * @property integer $id_direccion_remitente
 * @property integer $id_direccion_destino
 * @property integer $id_candado
 * @property integer $id_plataforma
 * @property integer $id_almacen
 * @property integer $id_consolidado
 * @property integer $num_intento_entrega
 * @property integer $b_retornado_centro_distribucion
 * @property integer $b_rechazado_cliente
 * @property integer $b_retornado_origen
 * @property string $txt_remitente
 * @property string $txt_destinatario
 * @property string $txt_token_transaccion_plataforma
 * @property integer $envio_data
 * @property string $fch_creacion
 *
 * @property CatEnviosEstados $idEnvioEstado
 * @property EntDirecciones $idDireccionDestino
 * @property EntDirecciones $idDireccionRemitente
 * @property EntAlmacenes $idAlmacen
 * @property EntCandados $idCandado
 * @property EntConsolidados $idConsolidado
 * @property EntPlataformas $idPlataforma
 * @property RelEnviosAlmacenes[] $relEnviosAlmacenes
 * @property EntAlmacenes[] $idAlmacens
 * @property RelEnviosAtributos[] $relEnviosAtributos
 * @property CatEnviosAtributos[] $idEnvioAtributos
 * @property RelEnviosConsolidados[] $relEnviosConsolidados
 * @property EntConsolidados[] $idConsolidados
 * @property WrkEnviosEventos[] $wrkEnviosEventos
 */
class EntEnvios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_envios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_envio_estado', 'id_direccion_destino', 'id_plataforma', 'txt_remitente', 'txt_destinatario', 'txt_token_transaccion_plataforma'], 'required'],
            [['id_envio_estado', 'id_direccion_remitente', 'id_direccion_destino', 'id_candado', 'id_plataforma', 'id_almacen', 'id_consolidado', 'num_intento_entrega', 'b_retornado_centro_distribucion', 'b_rechazado_cliente', 'b_retornado_origen', 'envio_data'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['uddi', 'txt_remitente', 'txt_destinatario', 'txt_token_transaccion_plataforma'], 'string', 'max' => 45],
            [['uddi'], 'unique'],
            [['id_envio_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatEnviosEstados::className(), 'targetAttribute' => ['id_envio_estado' => 'id_envio_estado']],
            [['id_direccion_destino'], 'exist', 'skipOnError' => true, 'targetClass' => EntDirecciones::className(), 'targetAttribute' => ['id_direccion_destino' => 'id_direccion']],
            [['id_direccion_remitente'], 'exist', 'skipOnError' => true, 'targetClass' => EntDirecciones::className(), 'targetAttribute' => ['id_direccion_remitente' => 'id_direccion']],
            [['id_almacen'], 'exist', 'skipOnError' => true, 'targetClass' => EntAlmacenes::className(), 'targetAttribute' => ['id_almacen' => 'id_almacen']],
            [['id_candado'], 'exist', 'skipOnError' => true, 'targetClass' => EntCandados::className(), 'targetAttribute' => ['id_candado' => 'id_candado']],
            [['id_consolidado'], 'exist', 'skipOnError' => true, 'targetClass' => EntConsolidados::className(), 'targetAttribute' => ['id_consolidado' => 'id_consolidado']],
            [['id_plataforma'], 'exist', 'skipOnError' => true, 'targetClass' => EntPlataformas::className(), 'targetAttribute' => ['id_plataforma' => 'id_plataforma']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio' => 'Id Envio',
            'uddi' => 'Uddi',
            'id_envio_estado' => 'Id Envio Estado',
            'id_direccion_remitente' => 'Id Direccion Remitente',
            'id_direccion_destino' => 'Id Direccion Destino',
            'id_candado' => 'Id Candado',
            'id_plataforma' => 'Id Plataforma',
            'id_almacen' => 'Id Almacen',
            'id_consolidado' => 'Id Consolidado',
            'num_intento_entrega' => 'Num Intento Entrega',
            'b_retornado_centro_distribucion' => 'B Retornado Centro Distribucion',
            'b_rechazado_cliente' => 'B Rechazado Cliente',
            'b_retornado_origen' => 'B Retornado Origen',
            'txt_remitente' => 'Txt Remitente',
            'txt_destinatario' => 'Txt Destinatario',
            'txt_token_transaccion_plataforma' => 'Txt Token Transaccion Plataforma',
            'envio_data' => 'Envio Data',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvioEstado()
    {
        return $this->hasOne(CatEnviosEstados::className(), ['id_envio_estado' => 'id_envio_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDireccionDestino()
    {
        return $this->hasOne(EntDirecciones::className(), ['id_direccion' => 'id_direccion_destino']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDireccionRemitente()
    {
        return $this->hasOne(EntDirecciones::className(), ['id_direccion' => 'id_direccion_remitente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacen()
    {
        return $this->hasOne(EntAlmacenes::className(), ['id_almacen' => 'id_almacen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCandado()
    {
        return $this->hasOne(EntCandados::className(), ['id_candado' => 'id_candado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidado()
    {
        return $this->hasOne(EntConsolidados::className(), ['id_consolidado' => 'id_consolidado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlataforma()
    {
        return $this->hasOne(EntPlataformas::className(), ['id_plataforma' => 'id_plataforma']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosAlmacenes()
    {
        return $this->hasMany(RelEnviosAlmacenes::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacens()
    {
        return $this->hasMany(EntAlmacenes::className(), ['id_almacen' => 'id_almacen'])->viaTable('rel_envios_almacenes', ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosAtributos()
    {
        return $this->hasMany(RelEnviosAtributos::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvioAtributos()
    {
        return $this->hasMany(CatEnviosAtributos::className(), ['id_envio_atributo' => 'id_envio_atributo'])->viaTable('rel_envios_atributos', ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosConsolidados()
    {
        return $this->hasMany(RelEnviosConsolidados::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidados()
    {
        return $this->hasMany(EntConsolidados::className(), ['id_consolidado' => 'id_consolidado'])->viaTable('rel_envios_consolidados', ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkEnviosEventos()
    {
        return $this->hasMany(WrkEnviosEventos::className(), ['id_envio' => 'id_envio']);
    }
}
