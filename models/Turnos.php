<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turnos".
 *
 * @property int $id_turno
 * @property string $nombre
 *
 * @property Alumno[] $alumnos
 */
class Turnos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turnos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_turno', 'nombre'], 'required'],
            [['id_turno'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['id_turno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_turno' => 'Id Turno',
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
        return $this->hasMany(Alumno::class, ['id_turno' => 'id_turno']);
    }

}
