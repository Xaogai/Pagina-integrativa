<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id_empresa
 * @property string $nombre
 * @property string $jefe_inmediato
 * @property string $perfil_profesional
 * @property string $cargo
 * @property string $nombre_lugar
 * @property string $calle
 * @property string $colonia
 * @property string $numero
 * @property string $codigo_postal
 * @property string $municipio
 * @property string $telefono_uno
 * @property string $telefono_dos
 * @property string $correo
 * @property string|null $logo
 *
 * @property HojaDatos[] $hojaDatos
 */
class Empresa extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo'], 'default', 'value' => null],
    
            // Campos obligatorios
            [['nombre', 'jefe_inmediato', 'perfil_profesional', 'cargo', 'nombre_lugar', 'calle', 'colonia', 'numero', 'codigo_postal', 'municipio', 'telefono_uno', 'telefono_dos', 'correo'], 'required', 'message' => 'Este campo es obligatorio'],
    
            // Solo letras y espacios
            [['nombre'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El nombre solo debe contener letras'],
            [['jefe_inmediato'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El jefe inmediato solo debe contener letras'],
            [['perfil_profesional'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El perfil profesional solo debe contener letras'],
            [['cargo'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El cargo solo debe contener letras'],
            [['nombre_lugar'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El nombre del lugar solo debe contener letras'],
            [['calle'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'La calle solo debe contener letras'],
            [['colonia'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'La colonia solo debe contener letras'],
            [['municipio'], 'match', 'pattern' => '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/', 'message' => 'El municipio solo debe contener letras'],
    
            // Solo números
            [['numero'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'El número solo debe contener dígitos'],
    
            [['codigo_postal'], 'match', 'pattern' => '/^[0-9]{5}$/', 'message' => 'El código postal debe tener exactamente 5 dígitos'],
    
            [['telefono_uno'], 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => 'El teléfono uno debe tener exactamente 10 dígitos'],
    
            [['telefono_dos'], 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => 'El teléfono dos debe tener exactamente 10 dígitos'],
    
            // Validar correo electrónico
            [['correo'], 'email', 'message' => 'Ingrese un correo electrónico válido'],
    
            // Longitudes máximas
            [['nombre', 'jefe_inmediato', 'perfil_profesional', 'calle', 'colonia', 'correo', 'logo'], 'string', 'max' => 100, 'tooLong' => 'Máximo 100 caracteres'],
            [['cargo', 'municipio'], 'string', 'max' => 80, 'tooLong' => 'Máximo 80 caracteres'],
            [['nombre_lugar'], 'string', 'max' => 150, 'tooLong' => 'Máximo 150 caracteres'],
            [['numero'], 'string', 'max' => 10, 'tooLong' => 'Máximo 10 caracteres'],
            [['codigo_postal', 'telefono_uno', 'telefono_dos'], 'string', 'max' => 15, 'tooLong' => 'Máximo 15 caracteres'],
        
            [['rfc'], 'string', 'max' => 13],
            [['fecha_insercion'], 'safe'],
            [['rfc'], 'match', 'pattern' => '/^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/', 
                'message' => 'RFC no válido'],
        ];
    }
    
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_empresa' => 'Id Empresa',
            'nombre' => 'Nombre Empresa',
            'jefe_inmediato' => 'Jefe inmediato',
            'perfil_profesional' => 'Perfil Profesional',
            'cargo' => 'Cargo',
            'nombre_lugar' => 'Nombre Lugar',
            'calle' => 'Calle',
            'colonia' => 'Colonia',
            'numero' => 'Numero',
            'codigo_postal' => 'Codigo Postal',
            'municipio' => 'Municipio',
            'telefono_uno' => 'Telefono Uno',
            'telefono_dos' => 'Telefono Dos',
            'correo' => 'Correo',
            'logo' => 'Logo',
            'rfc' => 'RFC',
            'fecha_insercion' => 'Fecha de Registro',
        ];
    }

    /**
     * Gets query for [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHojaDatos()
    {
        return $this->hasMany(HojaDatos::class, ['id_empresa' => 'id_empresa']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if ($insert && empty($this->fecha_insercion)) {
            $this->fecha_insercion = new Expression('CURDATE()');
        }
        
        return true;
    }

}
