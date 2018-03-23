<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_envios_estados".
 *
 * @property integer $id_envio_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property EntEnvios[] $entEnvios
 * @property WrkEnviosEventos[] $wrkEnviosEventos
 */
class CatEnviosEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_envios_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio_estado' => 'Id Envio Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEnvios()
    {
        return $this->hasMany(EntEnvios::className(), ['id_envio_estado' => 'id_envio_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkEnviosEventos()
    {
        return $this->hasMany(WrkEnviosEventos::className(), ['id_envio_estado' => 'id_envio_estado']);
    }
}
