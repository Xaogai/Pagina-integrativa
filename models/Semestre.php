<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Semestre".
 *
 * @property int $id_semestre
 * @property string $nombre
 */
class Semestre extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semestre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_semestre' => 'ID Semestre',
            'nombre' => 'Nombre',
        ];
    }
}
