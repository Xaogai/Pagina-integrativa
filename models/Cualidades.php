<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\models\GetAllRecordsTrait;

/**
 * This is the model class for table "Cualidades".
 *
 * @property int $id_cualidades
 * @property string $cualidades
 */
class Cualidades extends ActiveRecord
{
    use GetAllRecordsTrait; // Usar el trait

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cualidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cualidades'], 'required'],
            [['cualidades'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cualidades' => 'ID Cualidades',
            'cualidades' => 'Cualidades',
        ];
    }
}