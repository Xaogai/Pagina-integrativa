<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id_empresa
 * @property string $nombre
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
            [['nombre', 'perfil_profesional', 'cargo', 'nombre_lugar', 'calle', 'colonia', 'numero', 'codigo_postal', 'municipio', 'telefono_uno', 'telefono_dos', 'correo'], 'required'],
            [['nombre', 'perfil_profesional', 'calle', 'colonia', 'correo', 'logo'], 'string', 'max' => 100],
            [['cargo', 'municipio'], 'string', 'max' => 80],
            [['nombre_lugar'], 'string', 'max' => 150],
            [['numero'], 'string', 'max' => 10],
            [['codigo_postal', 'telefono_uno', 'telefono_dos'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_empresa' => 'Id Empresa',
            'nombre' => 'Nombre',
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

}
