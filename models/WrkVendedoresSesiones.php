<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_vendedores_sesiones".
 *
 * @property integer $id_vendedor
 * @property string $txt_token
 * @property string $fch_actualizacion
 *
 * @property EntVendedores $idVendedor
 */
class WrkVendedoresSesiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_vendedores_sesiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'txt_token'], 'required'],
            [['id_vendedor'], 'integer'],
            [['fch_actualizacion'], 'safe'],
            [['txt_token'], 'string', 'max' => 45],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vendedor' => 'Id Vendedor',
            'txt_token' => 'Txt Token',
            'fch_actualizacion' => 'Fch Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedor()
    {
        return $this->hasOne(EntVendedores::className(), ['id_vendedor' => 'id_vendedor']);
    }
}
