<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cartas_alumno".
 *
 * @property int $id_cartasalumno
 * @property int $id_alumno
 * @property string|null $hoja_datos
 * @property string|null $carta_presentacion
 * @property string|null $carta_aceptacion
 * @property string|null $carta_termino
 *
 * @property Alumnos $alumno
 */
class CartasAlumno extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cartas_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hoja_datos', 'carta_presentacion', 'carta_aceptacion', 'carta_termino'], 'default', 'value' => null],
            [['id_alumno'], 'required'],
            [['id_alumno'], 'integer'],
            [['hoja_datos', 'carta_presentacion', 'carta_aceptacion', 'carta_termino'], 'string', 'max' => 100],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cartasalumno' => 'Id Cartasalumno',
            'id_alumno' => 'Id Alumno',
            'hoja_datos' => 'Hoja Datos',
            'carta_presentacion' => 'Carta Presentacion',
            'carta_aceptacion' => 'Carta Aceptacion',
            'carta_termino' => 'Carta Termino',
        ];
    }

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::class, ['id_alumno' => 'id_alumno']);
    }

}
