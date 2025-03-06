<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cualidades".
 *
 * @property int $id_cualidades
 * @property string|null $cualidades
 *
 * @property Carrera[] $carreras
 */
class Cualidades extends \yii\db\ActiveRecord
{


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
            [['cualidades'], 'default', 'value' => null],
            [['cualidades'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cualidades' => 'Id Cualidades',
            'cualidades' => 'Cualidades',
        ];
    }

    /**
     * Gets query for [[Carreras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarreras()
    {
        return $this->hasMany(Carrera::class, ['id_cualidades' => 'id_cualidades']);
    }

}
