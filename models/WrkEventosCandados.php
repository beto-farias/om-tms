<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_eventos_candados".
 *
 * @property integer $id_evento_candado
 * @property integer $ent_candados_id_candado
 * @property integer $id_candado_estado
 * @property string $fch_evento
 * @property string $txt_notas
 *
 * @property CatCandadosEstados $idCandadoEstado
 * @property EntCandados $entCandadosIdCandado
 */
class WrkEventosCandados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_eventos_candados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ent_candados_id_candado', 'id_candado_estado'], 'required'],
            [['ent_candados_id_candado', 'id_candado_estado'], 'integer'],
            [['fch_evento'], 'safe'],
            [['txt_notas'], 'string', 'max' => 100],
            [['id_candado_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatCandadosEstados::className(), 'targetAttribute' => ['id_candado_estado' => 'id_candado_estado']],
            [['ent_candados_id_candado'], 'exist', 'skipOnError' => true, 'targetClass' => EntCandados::className(), 'targetAttribute' => ['ent_candados_id_candado' => 'id_candado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evento_candado' => 'Id Evento Candado',
            'ent_candados_id_candado' => 'Ent Candados Id Candado',
            'id_candado_estado' => 'Id Candado Estado',
            'fch_evento' => 'Fch Evento',
            'txt_notas' => 'Txt Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCandadoEstado()
    {
        return $this->hasOne(CatCandadosEstados::className(), ['id_candado_estado' => 'id_candado_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCandadosIdCandado()
    {
        return $this->hasOne(EntCandados::className(), ['id_candado' => 'ent_candados_id_candado']);
    }
}
