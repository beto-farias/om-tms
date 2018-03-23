<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_clientes_by_vendedor".
 *
 * @property integer $id_cliente
 * @property string $uddi
 * @property string $txt_nombre
 * @property string $txt_correo
 * @property string $txt_telefono_fijo
 * @property string $txt_telefono_movil
 * @property string $fch_alta
 * @property string $txt_notas
 * @property integer $b_habilitado
 * @property string $fch_asignado
 * @property integer $b_actual
 */
class VClientesByVendedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_clientes_by_vendedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'b_habilitado', 'b_actual'], 'integer'],
            [['uddi', 'txt_nombre'], 'required'],
            [['fch_alta', 'fch_asignado'], 'safe'],
            [['uddi', 'txt_nombre', 'txt_correo', 'txt_telefono_fijo', 'txt_telefono_movil', 'txt_notas'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
            'txt_correo' => 'Txt Correo',
            'txt_telefono_fijo' => 'Txt Telefono Fijo',
            'txt_telefono_movil' => 'Txt Telefono Movil',
            'fch_alta' => 'Fch Alta',
            'txt_notas' => 'Txt Notas',
            'b_habilitado' => 'B Habilitado',
            'fch_asignado' => 'Fch Asignado',
            'b_actual' => 'B Actual',
        ];
    }
}
