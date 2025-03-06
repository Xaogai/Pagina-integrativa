<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrera".
 *
 * @property int $id_carrera
 * @property string $nombre
 * @property int $id_cualidades
 *
 * @property Alumnos[] $alumnos
 * @property Cualidades $cualidades
 */
class Carrera extends \yii\db\ActiveRecord
{


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
            [['id_cualidades'], 'exist', 'skipOnError' => true, 'targetClass' => Cualidades::class, 'targetAttribute' => ['id_cualidades' => 'id_cualidades']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_carrera' => 'Id Carrera',
            'nombre' => 'Nombre',
            'id_cualidades' => 'Id Cualidades',
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumnos::class, ['id_carrera' => 'id_carrera']);
    }

    /**
     * Gets query for [[Cualidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCualidades()
    {
        return $this->hasOne(Cualidades::class, ['id_cualidades' => 'id_cualidades']);
    }

}
