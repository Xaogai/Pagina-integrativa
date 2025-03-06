<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "institucion".
 *
 * @property int $id_institucion
 * @property string $nombre
 *
 * @property Alumno[] $alumnos
 */
class Institucion extends \yii\db\ActiveRecord
{


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
            [['id_institucion', 'nombre'], 'required'],
            [['id_institucion'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['id_institucion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_institucion' => 'Id Institucion',
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
        return $this->hasMany(Alumno::class, ['id_institucion' => 'id_institucion']);
    }

}
