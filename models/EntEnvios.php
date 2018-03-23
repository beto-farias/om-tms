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
 * @property integer $num_intento_entrega
 * @property integer $b_retornado_centro_distribucion
 * @property integer $b_rechazado_cliente
 * @property integer $b_retornado_origen
 * @property string $txt_remitente
 * @property string $txt_destinatario
 *
 * @property CatEnviosEstados $idEnvioEstado
 * @property EntDirecciones $idDireccionDestino
 * @property EntDirecciones $idDireccionRemitente
 * @property EntCandados $idCandado
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
            [['id_envio_estado', 'id_direccion_destino', 'txt_remitente', 'txt_destinatario'], 'required'],
            [['id_envio_estado', 'id_direccion_remitente', 'id_direccion_destino', 'id_candado', 'num_intento_entrega', 'b_retornado_centro_distribucion', 'b_rechazado_cliente', 'b_retornado_origen'], 'integer'],
            [['uddi', 'txt_remitente', 'txt_destinatario'], 'string', 'max' => 45],
            [['id_envio_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatEnviosEstados::className(), 'targetAttribute' => ['id_envio_estado' => 'id_envio_estado']],
            [['id_direccion_destino'], 'exist', 'skipOnError' => true, 'targetClass' => EntDirecciones::className(), 'targetAttribute' => ['id_direccion_destino' => 'id_direccion']],
            [['id_direccion_remitente'], 'exist', 'skipOnError' => true, 'targetClass' => EntDirecciones::className(), 'targetAttribute' => ['id_direccion_remitente' => 'id_direccion']],
            [['id_candado'], 'exist', 'skipOnError' => true, 'targetClass' => EntCandados::className(), 'targetAttribute' => ['id_candado' => 'id_candado']],
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
            'num_intento_entrega' => 'Num Intento Entrega',
            'b_retornado_centro_distribucion' => 'B Retornado Centro Distribucion',
            'b_rechazado_cliente' => 'B Rechazado Cliente',
            'b_retornado_origen' => 'B Retornado Origen',
            'txt_remitente' => 'Txt Remitente',
            'txt_destinatario' => 'Txt Destinatario',
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
    public function getIdCandado()
    {
        return $this->hasOne(EntCandados::className(), ['id_candado' => 'id_candado']);
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
