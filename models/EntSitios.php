<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_sitios".
 *
 * @property integer $id_sitio
 * @property string $txt_nombre
 * @property string $txt_clave
 * @property integer $b_habilitado
 *
 * @property EntAlmacenes[] $entAlmacenes
 */
class EntSitios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_sitios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_clave'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sitio' => 'Id Sitio',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave' => 'Txt Clave',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntAlmacenes()
    {
        return $this->hasMany(EntAlmacenes::className(), ['id_sitio' => 'id_sitio']);
    }
}
