<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_envios_atributos".
 *
 * @property integer $id_envio_atributo
 * @property integer $id_tipo_dato
 * @property string $txt_nombre
 * @property integer $b_habilitado
 *
 * @property CatTiposDatos $idTipoDato
 * @property RelEnviosAtributos[] $relEnviosAtributos
 * @property EntEnvios[] $idEnvios
 */
class CatEnviosAtributos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_envios_atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_dato'], 'required'],
            [['id_tipo_dato', 'b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['id_tipo_dato'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposDatos::className(), 'targetAttribute' => ['id_tipo_dato' => 'id_tipo_dato']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio_atributo' => 'Id Envio Atributo',
            'id_tipo_dato' => 'Id Tipo Dato',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoDato()
    {
        return $this->hasOne(CatTiposDatos::className(), ['id_tipo_dato' => 'id_tipo_dato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEnviosAtributos()
    {
        return $this->hasMany(RelEnviosAtributos::className(), ['id_envio_atributo' => 'id_envio_atributo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_envio' => 'id_envio'])->viaTable('rel_envios_atributos', ['id_envio_atributo' => 'id_envio_atributo']);
    }
}
