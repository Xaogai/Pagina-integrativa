<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\rbac\PhpManager;

class RbacController extends Controller
{
    public function actionInit()
    {
        /** @var PhpManager $auth */
        $auth = Yii::$app->authManager;

        // Crear un rol "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Crear un permiso "manageUsers"
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Gestionar usuarios';
        $auth->add($manageUsers);

        // Asignar permiso al rol "admin"
        $auth->addChild($admin, $manageUsers);

        // Asignar el rol "admin" al usuario con ID 1
        $auth->assign($admin, 1);

        echo "RBAC configurado con éxito.\n";
    }
}
