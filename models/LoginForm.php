<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'message' => 'Este campo es obligatorio.'],
            ['email', 'email', 'message' => 'Ingresa un correo válido.'],
            ['email', 'match', 'pattern' => '/@cbt2metepec\.edu\.mx$/', 'message' => 'Solo se permiten correos institucionales (@cbt2metepec.edu.mx).'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
    

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Correo o contraseña incorrectos.');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findOne(['correo' => $this->email]);
        }
        return $this->_user;
    }
}
