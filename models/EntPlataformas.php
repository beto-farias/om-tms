<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Ent_plataformas".
 *
 * @property integer $id_plataforma
 * @property integer $id_cliente
 * @property string $uddi
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 */
class EntPlataformas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Ent_plataformas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'uddi', 'txt_nombre', 'txt_descripcion'], 'required'],
            [['id_cliente', 'b_habilitado'], 'integer'],
            [['uddi', 'txt_nombre'], 'string', 'max' => 45],
            [['txt_descripcion'], 'string', 'max' => 200],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => EntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_plataforma' => 'Id Plataforma',
            'id_cliente' => 'Id Cliente',
            'uddi' => 'Uddi',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}
