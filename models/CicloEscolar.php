<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Ciclo_escolar".
 *
 * @property int $id_ciclo
 * @property string $ciclo
 */
class CicloEscolar extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ciclo_escolar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ciclo'], 'required'],
            [['ciclo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ciclo' => 'ID Ciclo',
            'ciclo' => 'Ciclo',
        ];
    }
}