<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_almacenes".
 *
 * @property integer $id_almacen
 * @property integer $id_sitio
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property integer $b_habilitado
 *
 * @property EntSitios $idSitio
 * @property WrkStock[] $wrkStocks
 */
class EntAlmacenes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_almacenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sitio', 'txt_nombre', 'txt_clave'], 'required'],
            [['id_sitio', 'b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_clave'], 'string', 'max' => 5],
            [['id_sitio'], 'exist', 'skipOnError' => true, 'targetClass' => EntSitios::className(), 'targetAttribute' => ['id_sitio' => 'id_sitio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_almacen' => 'Id Almacen',
            'id_sitio' => 'Id Sitio',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSitio()
    {
        return $this->hasOne(EntSitios::className(), ['id_sitio' => 'id_sitio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkStocks()
    {
        return $this->hasMany(WrkStock::className(), ['id_almacen' => 'id_almacen']);
    }
}
