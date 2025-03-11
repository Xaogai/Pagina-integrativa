<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hoja_datos".
 *
 * @property int $id_hojadatos
 * @property int $id_alumno
 * @property int $id_empresa
 * @property string|null $status
 * @property int $id_semestre
 * @property int $id_ciclo
 * @property int $id_formato
 * @property string $fecha_emision
 * @property string $fecha_aceptacion
 * @property string $fecha_termino
 *
 * @property Alumnos $alumno
 * @property CicloEscolar $ciclo
 * @property Empresa $empresa
 * @property FondoCbt $formato
 * @property Semestre $semestre
 */
class HojaDatos extends \yii\db\ActiveRecord
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
        return 'hoja_datos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => null],
            [['id_alumno', 'id_empresa', 'id_semestre', 'id_ciclo', 'id_formato', 'fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'required'],
            [['id_alumno', 'id_empresa', 'id_semestre', 'id_ciclo', 'id_formato'], 'integer'],
            [['status'], 'string'],
            [['fecha_emision', 'fecha_aceptacion', 'fecha_termino'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['id_empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['id_empresa' => 'id_empresa']],
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
            'id_hojadatos' => 'Id Hojadatos',
            'id_alumno' => 'Id Alumno',
            'id_empresa' => 'Id Empresa',
            'status' => 'Status',
            'id_semestre' => 'Id Semestre',
            'id_ciclo' => 'Id Ciclo',
            'id_formato' => 'Id Formato',
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
     * Gets query for [[Empresa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id_empresa' => 'id_empresa']);
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
