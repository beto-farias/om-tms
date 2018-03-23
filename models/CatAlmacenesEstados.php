<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_almacenes_estados".
 *
 * @property integer $id_almacen_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property WrkAlmacenesEventos[] $wrkAlmacenesEventos
 */
class CatAlmacenesEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_almacenes_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_almacen_estado' => 'Id Almacen Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkAlmacenesEventos()
    {
        return $this->hasMany(WrkAlmacenesEventos::className(), ['id_almacen_estado' => 'id_almacen_estado']);
    }
}
