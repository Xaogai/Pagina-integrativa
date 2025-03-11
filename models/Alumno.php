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
 */
class Alumno extends \yii\db\ActiveRecord
{
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
            [['id_alumno', 'correo', 'curp', 'nombre', 'apellido_paterno', 'apellido_materno', 'id_semestreactual', 'id_institucion', 'nss', 'fecha_nacimiento', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_ciclo'], 'required'],
            [['id_alumno', 'id_semestreactual', 'id_institucion', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_ciclo'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['sexo'], 'string'],
            [['correo', 'colonia'], 'string', 'max' => 100],
            [['curp', 'nss', 'calle'], 'string', 'max' => 50],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'municipio'], 'string', 'max' => 80],
            [['telefono_uno', 'telefono_dos'], 'string', 'max' => 15],
            [['numero', 'codigo_postal'], 'string', 'max' => 10],
            [['correo'], 'unique'],
            [['curp'], 'unique'],
            [['nss'], 'unique'],
            [['id_alumno'], 'unique'],
            [['id_semestreactual'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::class, 'targetAttribute' => ['id_semestreactual' => 'id_semestre']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Institucion::class, 'targetAttribute' => ['id_institucion' => 'id_institucion']],
            [['id_grado'], 'exist', 'skipOnError' => true, 'targetClass' => Grado::class, 'targetAttribute' => ['id_grado' => 'id_grado']],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::class, 'targetAttribute' => ['id_grupo' => 'id_grupo']],
            [['id_carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::class, 'targetAttribute' => ['id_carrera' => 'id_carrera']],
            [['id_turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turnos::class, 'targetAttribute' => ['id_turno' => 'id_turno']],
            [['id_ciclo'], 'exist', 'skipOnError' => true, 'targetClass' => CicloEscolar::class, 'targetAttribute' => ['id_ciclo' => 'id_ciclo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alumno' => 'Id Alumno',
            'correo' => 'Correo',
            'curp' => 'Curp',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'id_semestreactual' => 'Id Semestreactual',
            'id_institucion' => 'Id Institucion',
            'nss' => 'Número de seguridad social (NSS)',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'sexo' => 'Sexo',
            'id_grado' => 'Id Grado',
            'id_grupo' => 'Id Grupo',
            'id_carrera' => 'Id Carrera',
            'id_turno' => 'Id Turno',
            'telefono_uno' => 'Telefono Uno',
            'telefono_dos' => 'Telefono Dos',
            'calle' => 'Calle',
            'numero' => 'Numero',
            'colonia' => 'Colonia',
            'codigo_postal' => 'Codigo Postal',
            'municipio' => 'Municipio',
            'id_ciclo' => 'Id Ciclo',
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

    /**
     * Gets query for [[CartaAceptacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaAceptacions()
    {
        return $this->hasMany(CartaAceptacion::class, ['id_alumno' => 'id_alumno']);
    }

    /**
     * Gets query for [[CartaPresentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaPresentacions()
    {
        return $this->hasMany(CartaPresentacion::class, ['id_alumno' => 'id_alumno']);
    }

    /**
     * Gets query for [[CartaTerminos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaTerminos()
    {
        return $this->hasMany(CartaTermino::class, ['id_alumno' => 'id_alumno']);
    }

    /**
     * Gets query for [[CartasAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartasAlumnos()
    {
        return $this->hasMany(CartasAlumno::class, ['id_alumno' => 'id_alumno']);
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
     * Gets query for [[Grado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrado()
    {
        return $this->hasOne(Grado::class, ['id_grado' => 'id_grado']);
    }

    /**
     * Gets query for [[Grupo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupos::class, ['id_grupo' => 'id_grupo']);
    }

    /**
     * Gets query for [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHojaDatos()
    {
        return $this->hasMany(HojaDatos::class, ['id_alumno' => 'id_alumno']);
    }

    /**
     * Gets query for [[Institucion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstitucion()
    {
        return $this->hasOne(Institucion::class, ['id_institucion' => 'id_institucion']);
    }

    /**
     * Gets query for [[Semestreactual]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemestreactual()
    {
        return $this->hasOne(Semestre::class, ['id_semestre' => 'id_semestreactual']);
    }

    /**
     * Gets query for [[Turno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTurno()
    {
        return $this->hasOne(Turnos::class, ['id_turno' => 'id_turno']);
    }
}
