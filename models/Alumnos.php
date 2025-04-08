<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumnos".
 */
class Alumnos extends \yii\db\ActiveRecord
{
    const SEXO_F = 'F';
    const SEXO_M = 'M';

    public static function tableName()
    {
        return 'alumnos';
    }

    public function rules()
    {
        return [
            [['sexo', 'telefono_uno', 'telefono_dos', 'calle', 'numero', 'colonia', 'codigo_postal', 'municipio'], 'default', 'value' => null],

            [['correo', 'curp', 'nombre', 'apellido_paterno', 'apellido_materno', 'id_semestreactual', 'id_institucion', 'nss', 'fecha_nacimiento', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_usuario', 'id_ciclo'], 'required', 'message' => 'Este campo es obligatorio.'],

            [['id_semestreactual', 'id_institucion', 'id_grado', 'id_grupo', 'id_carrera', 'id_turno', 'id_usuario', 'id_ciclo'], 'integer', 'message' => 'Debe ser un número entero.'],

            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],

            [['sexo'], 'required', 'message' => 'Seleccione un sexo válido.'],
            [['sexo'], 'in', 'range' => [self::SEXO_F, self::SEXO_M], 'message' => 'Seleccione un sexo válido.'],

            [['correo', 'colonia'], 'string', 'max' => 100, 'tooLong' => 'No puede exceder los 100 caracteres.'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'municipio'], 'string', 'max' => 80, 'tooLong' => 'No puede exceder los 80 caracteres.'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'municipio'], 'match', 'pattern' => '/^[^\d]+$/', 'message' => 'No debe contener números.'],

            [['curp', 'nss', 'calle'], 'string', 'max' => 50, 'tooLong' => 'No puede exceder los 50 caracteres.'],
            [['curp'], 'match', 'pattern' => '/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/', 'message' => 'CURP no válida.'],
            [['nss'], 'match', 'pattern' => '/^(\d{2})(\d{2})(\d{2})\d{5}$/', 'message' => 'NSS no válido.'],

            [['telefono_uno', 'telefono_dos'], 'integer', 'message' => 'No puede contener letras.'],
            [['telefono_uno', 'telefono_dos'], 'match', 'pattern' => '/^(\d{10})$/', 'message' => 'Número no válido.'],

            [['codigo_postal'], 'string', 'max' => 10, 'tooLong' => 'No puede exceder los 10 caracteres.'],
            [['codigo_postal'], 'match', 'pattern' => '/^\d{4,5}$/', 'message' => 'Código no válido.'],

            [['numero'], 'integer', 'message' => 'No puede contener letras.'],

            [['correo', 'curp', 'nss'], 'unique'],

            [['calle', 'colonia', 'municipio'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚñáéíóúÑ\s]+$/', 'message' => 'Dirección no válida.'],

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

    public function getCarrera()
    {
        return $this->hasOne(Carrera::class, ['id_carrera' => 'id_carrera']);
    }
}
