<?php
namespace app\components;

use Yii;

class Permisos
{
    public static function puedeEditar()
    {
        $user = Yii::$app->user;
        
        // Primero verifica si hay datos en la sesión
        $sessionRole = Yii::$app->session->get('user_role');
        if ($sessionRole && in_array($sessionRole, ['SUPERVINCULACION', 'VINCULACION'])) {
            return true;
        }
        
        // Luego verifica el método normal
        if ($user->isGuest || $user->identity === null) {
            return false;
        }
        
        return in_array($user->identity->tipo_usuario, ['SUPERVINCULACION', 'VINCULACION']);
    }

    public static function esSuper()
    {
        $user = Yii::$app->user;
        if ($user->isGuest || $user->identity === null) {
            return false;
        }
        
        return $user->identity->tipo_usuario === 'SUPERVINCULACION';
    }

    public static function puedeVerPanelAdmin()
    {
        $user = Yii::$app->user;
        if ($user->isGuest || $user->identity === null) {
            return false;
        }
        
        // Lógica para verificar el panel de administración
        return in_array($user->identity->tipo_usuario, ['SUPERVINCULACION', 'ADMIN']);
    }
}