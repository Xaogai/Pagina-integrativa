<?php
namespace app\components;

use Yii;

class Permisos
{
    public static function puedeEditar()
    {
        $user = Yii::$app->user;
        return $user->identity->tipo_usuario === 'SUPERVINCULACION' || 
               $user->identity->tipo_usuario === 'VINCULACION';
    }

    public static function esSuper()
    {
        return Yii::$app->user->identity->tipo_usuario === 'SUPERVINCULACION';
    }

    public static function puedeVerPanelAdmin()
    {
        return self::esSuper();
    }
}