<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_clientes".
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
 *
 * @property RelVendedoresClientes[] $relVendedoresClientes
 * @property WrkVentas[] $wrkVentas
 */
class EntClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uddi', 'txt_nombre'], 'required'],
            [['fch_alta'], 'safe'],
            [['b_habilitado'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelVendedoresClientes()
    {
        return $this->hasMany(RelVendedoresClientes::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkVentas()
    {
        return $this->hasMany(WrkVentas::className(), ['id_cliente' => 'id_cliente']);
    }
}
