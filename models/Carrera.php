<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Carrera".
 *
 * @property int $id_carrera
 * @property string $nombre
 * @property int $id_cualidades
 */
class Carrera extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'id_cualidades'], 'required'],
            [['id_cualidades'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_carrera' => 'ID Carrera',
            'nombre' => 'Nombre',
            'id_cualidades' => 'ID Cualidades',
        ];
    }
}