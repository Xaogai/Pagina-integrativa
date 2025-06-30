<?php

namespace app\models;
use app\models\FondoCbt;


use Yii;

/**
 * This is the model class for table "carta_presentacion".
 *
 * @property int $id_cartapresentacion
 * @property int $id_formato
 * @property int $id_alumno
 * @property string|null $status
 * @property int $id_semestre
 * @property int $id_carrera
 * @property int $id_ciclo
 * @property string $fecha_emision
 * @property string $fecha_aceptacion   
 * @property string $fecha_termino
 *
 * @property Alumnos $alumno
 * @property CicloEscolar $ciclo
 * @property FondoCbt $formato
 * @property Semestre $semestre
 * @property Carrera $carrera
 */

class CartaPresentacion extends \yii\db\ActiveRecord
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
        return 'carta_presentacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => null],
            [['id_formato', 'id_alumno', 'id_semestre', 'id_ciclo', 'fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'required'],
            [['id_formato', 'id_alumno', 'id_semestre', 'id_ciclo'], 'integer'],
            [['status'], 'string'],
            [['fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['id_semestre'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::class, 'targetAttribute' => ['id_semestre' => 'id_semestre']],
            [['id_ciclo'], 'exist', 'skipOnError' => true, 'targetClass' => CicloEscolar::class, 'targetAttribute' => ['id_ciclo' => 'id_ciclo']],
            [['id_formato'], 'exist', 'skipOnError' => true, 'targetClass' => FondoCbt::class, 'targetAttribute' => ['id_formato' => 'id_fondo']],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cartapresentacion' => 'Id Cartapresentacion',
            'id_formato' => 'Id Formato',
            'id_alumno' => 'Id Alumno',
            'id_carrera' => 'Id Carrera',
            'status' => 'Status',
            'id_semestre' => 'Id Semestre',
            'id_ciclo' => 'Id Ciclo',
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
     * Gets query for [[Formato]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFormato()
    {
        return $this->hasOne(FondoCbt::class, ['id_fondo' => 'id_formato']);
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
     * Gets query for [[Carrera]].
     *
    * @return \yii\db\ActiveQuery
     */
    public function getCarrera()
    {
        return $this->hasOne(Carrera::class, ['id_carrera' => 'id_carrera']);
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
