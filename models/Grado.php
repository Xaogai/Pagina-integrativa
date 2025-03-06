<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grado".
 *
 * @property int $id_grado
 * @property string $nombre
 *
 * @property Alumno[] $alumnos
 */
class Grado extends \yii\db\ActiveRecord
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
            [['id_grado', 'nombre'], 'required'],
            [['id_grado'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['id_grado'], 'unique'],
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
        return $this->hasMany(Alumno::class, ['id_grado' => 'id_grado']);
    }

}
