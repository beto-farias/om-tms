<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_consolidados_eventos".
 *
 * @property integer $id_consolidado_evento
 * @property integer $id_consolidado
 * @property integer $id_consolidado_estado
 * @property string $fch_evento
 * @property string $txt_notas
 *
 * @property CatConsolidadosEstados $idConsolidadoEstado
 * @property EntConsolidados $idConsolidado
 */
class WrkConsolidadosEventos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_consolidados_eventos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_consolidado', 'id_consolidado_estado'], 'required'],
            [['id_consolidado', 'id_consolidado_estado'], 'integer'],
            [['fch_evento'], 'safe'],
            [['txt_notas'], 'string', 'max' => 100],
            [['id_consolidado_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatConsolidadosEstados::className(), 'targetAttribute' => ['id_consolidado_estado' => 'id_consolidado_estado']],
            [['id_consolidado'], 'exist', 'skipOnError' => true, 'targetClass' => EntConsolidados::className(), 'targetAttribute' => ['id_consolidado' => 'id_consolidado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_consolidado_evento' => 'Id Consolidado Evento',
            'id_consolidado' => 'Id Consolidado',
            'id_consolidado_estado' => 'Id Consolidado Estado',
            'fch_evento' => 'Fch Evento',
            'txt_notas' => 'Txt Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidadoEstado()
    {
        return $this->hasOne(CatConsolidadosEstados::className(), ['id_consolidado_estado' => 'id_consolidado_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdConsolidado()
    {
        return $this->hasOne(EntConsolidados::className(), ['id_consolidado' => 'id_consolidado']);
    }
}
