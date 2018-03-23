<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_citas".
 *
 * @property integer $id_cita
 * @property integer $id_vendedor
 * @property integer $id_cliente
 * @property string $uddi
 * @property string $fch_cita
 * @property integer $num_hora_cita
 * @property string $txt_notas
 * @property integer $b_confirmada
 * @property integer $b_cubierta
 * @property integer $b_habilitada
 * @property integer $num_semana
 *
 * @property EntVendedores $idVendedor
 * @property EntClientes $idCliente
 */
class WrkCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_cliente', 'uddi', 'fch_cita', 'num_hora_cita', 'num_semana'], 'required'],
            [['id_vendedor', 'id_cliente', 'num_hora_cita', 'b_confirmada', 'b_cubierta', 'b_habilitada', 'num_semana'], 'integer'],
            [['fch_cita'], 'safe'],
            [['txt_notas'], 'string'],
            [['uddi'], 'string', 'max' => 45],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => EntVendedores::className(), 'targetAttribute' => ['id_vendedor' => 'id_vendedor']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => EntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cita' => 'Id Cita',
            'id_vendedor' => 'Id Vendedor',
            'id_cliente' => 'Id Cliente',
            'uddi' => 'Uddi',
            'fch_cita' => 'Fch Cita',
            'num_hora_cita' => 'Num Hora Cita',
            'txt_notas' => 'Txt Notas',
            'b_confirmada' => 'B Confirmada',
            'b_cubierta' => 'B Cubierta',
            'b_habilitada' => 'B Habilitada',
            'num_semana' => 'Num Semana',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendedor()
    {
        return $this->hasOne(EntVendedores::className(), ['id_vendedor' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCliente()
    {
        return $this->hasOne(EntClientes::className(), ['id_cliente' => 'id_cliente']);
    }
}
