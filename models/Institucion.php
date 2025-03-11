<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Institucion".
 *
 * @property int $id_institucion
 * @property string $nombre
 */
class Institucion extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'institucion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_institucion' => 'ID Institución',
            'nombre' => 'Nombre',
        ];
    }
}