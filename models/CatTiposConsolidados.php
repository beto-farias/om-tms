<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_consolidados".
 *
 * @property integer $id_tipo_consolidado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property EntConsolidados[] $entConsolidados
 */
class CatTiposConsolidados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_consolidados';
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
            [['txt_descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_consolidado' => 'Id Tipo Consolidado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntConsolidados()
    {
        return $this->hasMany(EntConsolidados::className(), ['id_tipo_consolidado' => 'id_tipo_consolidado']);
    }
}
