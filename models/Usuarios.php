<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuarios extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'usuarios';  // Nombre de la tabla en la base de datos
    }

    // Implementa el método de IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne(['id_usuario' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Si usas tokens de acceso, este método es necesario
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id_usuario;  // Devolver el ID del usuario
    }

    public function getAuthKey()
    {
        // Retorna una clave de autenticación, puedes implementar un sistema de autenticación de claves si lo deseas
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        // Valida la clave de autenticación
        return $this->getAuthKey() === $authKey;
    }
}
