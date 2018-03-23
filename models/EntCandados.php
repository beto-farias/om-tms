<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_candados".
 *
 * @property integer $id_candado
 * @property integer $id_candado_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $num_cantidad_envio
 * @property string $fch_creacion
 *
 * @property CatCandadosEstados $idCandadoEstado
 * @property EntEnvios[] $entEnvios
 * @property WrkEventosCandados[] $wrkEventosCandados
 */
class EntCandados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_candados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_candado_estado', 'txt_nombre', 'num_cantidad_envio'], 'required'],
            [['id_candado_estado', 'num_cantidad_envio'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_descripcion'], 'string', 'max' => 200],
            [['id_candado_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatCandadosEstados::className(), 'targetAttribute' => ['id_candado_estado' => 'id_candado_estado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_candado' => 'Id Candado',
            'id_candado_estado' => 'Id Candado Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'num_cantidad_envio' => 'Num Cantidad Envio',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCandadoEstado()
    {
        return $this->hasOne(CatCandadosEstados::className(), ['id_candado_estado' => 'id_candado_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_candado' => 'id_candado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkEventosCandados()
    {
        return $this->hasMany(WrkEventosCandados::className(), ['ent_candados_id_candado' => 'id_candado']);
    }
}
