<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carta_aceptacion".
 *
 * @property int $id_cartaaceptacion
 * @property int $id_alumno
 * @property string|null $status
 * @property string|null $comentario_vinculacion
 * @property int $id_semestre
 * @property int $id_ciclo
 * @property string $area
 * @property string $fecha_inicio_servicio
 * @property string $fecha_termino_servicio
 * @property string $horario
 * @property string $fecha_emision
 * @property string|null $fecha_aceptacion
 * @property string|null $fecha_termino
 * @property string|null $fecha_insercion
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
            [['id_alumno', 'id_semestre', 'id_ciclo', 'area', 'horario', 'fecha_inicio_servicio', 'fecha_termino_servicio'], 'required'],
            [['id_alumno', 'id_semestre', 'id_ciclo'], 'integer'],
            [['status', 'comentario_vinculacion'], 'string'],
            [['fecha_inicio_servicio', 'fecha_termino_servicio', 'fecha_emision', 'fecha_aceptacion', 'fecha_termino', 'fecha_insercion'], 'safe'],
            [['area'], 'string', 'max' => 100],
            [['horario'], 'string', 'max' => 200],
            ['status', 'default', 'value' => self::STATUS_EN_REVISION],
            ['status', 'in', 'range' => [self::STATUS_ACEPTADO, self::STATUS_EN_REVISION, self::STATUS_RECHAZADO]],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::class, 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['id_semestre'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::class, 'targetAttribute' => ['id_semestre' => 'id_semestre']],
            [['id_ciclo'], 'exist', 'skipOnError' => true, 'targetClass' => CicloEscolar::class, 'targetAttribute' => ['id_ciclo' => 'id_ciclo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($insert) {
            $this->fecha_insercion = $now;
        } else {
            #$this->fecha_modificacion = $now;
        }

        // Si se acepta o rechaza, actualizar fechas correspondientes
        if ($this->isAttributeChanged('status')) {
            if ($this->status === self::STATUS_ACEPTADO) {
                $this->fecha_aceptacion = date('Y-m-d');
            } elseif ($this->status === self::STATUS_RECHAZADO) {
                $this->fecha_termino = date('Y-m-d');
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cartaaceptacion' => 'ID',
            'id_alumno' => 'Alumno',
            'status' => 'Estado',
            'comentario_vinculacion' => 'Comentario',
            'id_semestre' => 'Semestre',
            'id_ciclo' => 'Ciclo Escolar',
            'area' => 'Área',
            'fecha_inicio_servicio' => 'Fecha Inicio Servicio',
            'fecha_termino_servicio' => 'Fecha Término Servicio',
            'horario' => 'Horario',
            'fecha_emision' => 'Fecha Emisión',
            'fecha_aceptacion' => 'Fecha Aceptación',
            'fecha_termino' => 'Fecha Término',
            'fecha_insercion' => 'Fecha Creación',
            #'fecha_modificacion' => 'Última Modificación',
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
     * Gets query for [[Empresa]] through [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id_empresa' => 'id_empresa'])
            ->viaTable('hoja_datos', ['id_alumno' => 'id_alumno']);
    }

    /**
     * @return array Status options
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACEPTADO => 'Aceptado',
            self::STATUS_EN_REVISION => 'En Revisión',
            self::STATUS_RECHAZADO => 'Rechazado',
        ];
    }

    /**
     * @return string
     */
    public function getStatusLabel()
    {
        return self::optsStatus()[$this->status] ?? 'Desconocido';
    }
}