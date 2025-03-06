<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grado".
 *
 * @property int $id_grado
 * @property string $nombre
 *
 * @property Alumnos[] $alumnos
 */
class Grados extends \yii\db\ActiveRecord
{


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
            'id_grado' => 'Id Grado',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumnos::class, ['id_grado' => 'id_grado']);
    }

}
