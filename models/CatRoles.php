<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_roles".
 *
 * @property integer $id_rol
 * @property string $txt_nombre
 * @property integer $b_habilitado
 *
 * @property EntVendedores[] $entVendedores
 */
class CatRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rol' => 'Id Rol',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntVendedores()
    {
        return $this->hasMany(EntVendedores::className(), ['id_rol' => 'id_rol']);
    }
}
