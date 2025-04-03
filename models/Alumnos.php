<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumnos".
 *
 * @property int $id_alumno
 * @property string $correo
 * @property string $curp
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property int $id_semestreactual
 * @property int $id_institucion
 * @property string $nss
 * @property string $fecha_nacimiento
 * @property string|null $sexo
 * @property int $id_grado
 * @property int $id_grupo
 * @property int $id_carrera
 * @property int $id_turno
 * @property int $id_usuario
 * @property string|null $telefono_uno
 * @property string|null $telefono_dos
 * @property string|null $calle
 * @property string|null $numero
 * @property string|null $colonia
 * @property string|null $codigo_postal
 * @property string|null $municipio
 * @property int $id_ciclo
 *
 * @property Carrera $carrera
 * @property CartaAceptacion[] $cartaAceptacions
 * @property CartaPresentacion[] $cartaPresentacions
 * @property CartaTermino[] $cartaTerminos
 * @property CartasAlumno[] $cartasAlumnos
 * @property CicloEscolar $ciclo
 * @property Grado $grado
 * @property Grupos $grupo
 * @property HojaDatos[] $hojaDatos
 * @property Institucion $institucion
 * @property Semestre $semestreactual
 * @property Turnos $turno
 * @property Usuarios $usuario
 */
class Alumnos extends \yii\db\ActiveRecord
{
    /**
     * ENUM field values
     */
    const SEXO_F = 'F';
    const SEXO_M = 'M';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumnos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sexo', 'telefono_uno', 'telefono_dos', 'calle', 'numero', 'colonia', 'codigo_postal', 'municipio'], 'default', 'value' => null],
            [['correo', 'curp', 'nombre', 'apellido_paterno', 'apellido_materno', 'id_semestreactual', 'id_institucion', 'nss', 'fecha_nacimiento', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_usuario', 'id_ciclo'], 'required'],
            [['id_semestreactual', 'id_institucion', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_usuario', 'id_ciclo'], 'integer'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            [['sexo'], 'in', 'range' => [self::SEXO_F, self::SEXO_M]],
            [['correo', 'colonia'], 'string', 'max' => 100],
            [['curp', 'nss', 'calle'], 'string', 'max' => 50],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'municipio'], 'string', 'max' => 80],
            [['telefono_uno', 'telefono_dos'], 'string', 'max' => 15],
            [['numero', 'codigo_postal'], 'string', 'max' => 10],
            [['correo', 'curp', 'nss'], 'unique'],
            [['id_semestreactual'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::class, 'targetAttribute' => ['id_semestreactual' => 'id_semestre']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Institucion::class, 'targetAttribute' => ['id_institucion' => 'id_institucion']],
            [['id_grado'], 'exist', 'skipOnError' => true, 'targetClass' => Grado::class, 'targetAttribute' => ['id_grado' => 'id_grado']],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::class, 'targetAttribute' => ['id_grupo' => 'id_grupo']],
            [['id_carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::class, 'targetAttribute' => ['id_carrera' => 'id_carrera']],
            [['id_turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turnos::class, 'targetAttribute' => ['id_turno' => 'id_turno']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_ciclo'], 'exist', 'skipOnError' => true, 'targetClass' => CicloEscolar::class, 'targetAttribute' => ['id_ciclo' => 'id_ciclo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alumno' => 'ID Alumno',
            'correo' => 'Correo',
            'curp' => 'CURP',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'id_semestreactual' => 'Semestre Actual',
            'id_institucion' => 'Institución',
            'nss' => 'NSS',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'sexo' => 'Sexo',
            'id_grado' => 'Grado',
            'id_grupo' => 'Grupo',
            'id_carrera' => 'Carrera',
            'id_turno' => 'Turno',
            'id_usuario' => 'Usuario',
            'telefono_uno' => 'Teléfono Uno',
            'telefono_dos' => 'Teléfono Dos',
            'calle' => 'Calle',
            'numero' => 'Número',
            'colonia' => 'Colonia',
            'codigo_postal' => 'Código Postal',
            'municipio' => 'Municipio',
            'id_ciclo' => 'Ciclo Escolar',
        ];
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
}
