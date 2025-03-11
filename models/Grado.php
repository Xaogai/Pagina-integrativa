<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Grado".
 *
 * @property int $id_grado
 * @property string $nombre
 */
class Grado extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grado';
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
            'id_grado' => 'ID Grado',
            'nombre' => 'Nombre',
        ];
    }
}