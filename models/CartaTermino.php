<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carta_termino".
 *
 * @property int $id_cartatermino
 * @property int $id_alumno
 * @property string|null $status
 * @property int $id_semestre
 * @property int $id_ciclo
 * @property string $fecha_emision
 * @property string $fecha_aceptacion
 *
 * @property Alumno $alumno
 * @property CicloEscolar $ciclo
 * @property Semestre $semestre
 */
class CartaTermino extends \yii\db\ActiveRecord
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
        return 'carta_termino';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => null],
            [['id_cartatermino', 'id_alumno', 'id_semestre', 'id_ciclo', 'fecha_emision', 'fecha_aceptacion'], 'required'],
            [['id_cartatermino', 'id_alumno', 'id_semestre', 'id_ciclo'], 'integer'],
            [['status'], 'string'],
            [['fecha_emision', 'fecha_aceptacion'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['id_cartatermino'], 'unique'],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
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
            'id_cartatermino' => 'Id Cartatermino',
            'id_alumno' => 'Id Alumno',
            'status' => 'Status',
            'id_semestre' => 'Id Semestre',
            'id_ciclo' => 'Id Ciclo',
            'fecha_emision' => 'Fecha Emision',
            'fecha_aceptacion' => 'Fecha Aceptacion',
        ];
    }

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumno::class, ['id_alumno' => 'id_alumno']);
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
}
