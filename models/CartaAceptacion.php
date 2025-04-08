<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carta_aceptacion".
 *
 * @property int $id_cartaaceptacion
 * @property int $id_alumno
 * @property string|null $status
 * @property int $id_semestre
 * @property int $id_ciclo
 * @property string $area
 * @property string $fecha_inicio_servicio
 * @property string $fecha_termino_servicio
 * @property string $horario
 * @property string $fecha_emision
 * @property string $fecha_aceptacion
 * @property string $fecha_termino
 *
 * @property Alumnos $alumno
 * @property CicloEscolar $ciclo
 * @property Semestre $semestre
 */
class CartaAceptacion extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_ACEPTADO = 'ACEPTADO';
    const STATUS_EN_REVISION = 'EN REVISION';
    const STATUS_RECHAZADO = 'RECHAZADO';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carta_aceptacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => null],
            [['id_alumno', 'id_semestre', 'id_ciclo', 'area', 'fecha_inicio_servicio', 'fecha_termino_servicio', 'horario', 'fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'required'],
            [['id_alumno', 'id_semestre', 'id_ciclo'], 'integer'],
            [['status'], 'string'],
            [['fecha_inicio_servicio', 'fecha_termino_servicio', 'fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'safe'],
            [['area'], 'string', 'max' => 100],
            [['horario'], 'string', 'max' => 200],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['id_semestre'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::class, 'targetAttribute' => ['id_semestre' => 'id_semestre']],
            [['id_ciclo'], 'exist', 'skipOnError' => true, 'targetClass' => CicloEscolar::class, 'targetAttribute' => ['id_ciclo' => 'id_ciclo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cartaaceptacion' => 'Id Cartaaceptacion',
            'id_alumno' => 'Id Alumno',
            'status' => 'Status',
            'id_semestre' => 'Id Semestre',
            'id_ciclo' => 'Id Ciclo',
            'area' => 'Area',
            'fecha_inicio_servicio' => 'Fecha Inicio Servicio',
            'fecha_termino_servicio' => 'Fecha Termino Servicio',
            'horario' => 'Horario',
            'fecha_emision' => 'Fecha Emision',
            'fecha_aceptacion' => 'Fecha Aceptacion',
            'fecha_termino' => 'Fecha Termino',
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

    /**
     * Gets query for [[Ciclo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCiclo()
    {
        return $this->hasOne(CicloEscolar::class, ['id_ciclo' => 'id_ciclo']);
    }

    /**
     * Gets query for [[Semestre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemestre()
    {
        return $this->hasOne(Semestre::class, ['id_semestre' => 'id_semestre']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACEPTADO => 'ACEPTADO',
            self::STATUS_EN_REVISION => 'EN REVISION',
            self::STATUS_RECHAZADO => 'RECHAZADO',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusAceptado()
    {
        return $this->status === self::STATUS_ACEPTADO;
    }

    public function setStatusToAceptado()
    {
        $this->status = self::STATUS_ACEPTADO;
    }

    /**
     * @return bool
     */
    public function isStatusEnRevision()
    {
        return $this->status === self::STATUS_EN_REVISION;
    }

    public function setStatusToEnRevision()
    {
        $this->status = self::STATUS_EN_REVISION;
    }

    /**
     * @return bool
     */
    public function isStatusRechazado()
    {
        return $this->status === self::STATUS_RECHAZADO;
    }

    public function setStatusToRechazado()
    {
        $this->status = self::STATUS_RECHAZADO;
    }

    // En models/CartaAceptacion.php
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id_empresa' => 'id_empresa']);
    }

}
