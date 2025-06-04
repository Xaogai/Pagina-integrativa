<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuarios;

class SuperVincController extends Controller
{
 
    public function actionPanelPermisos()
    {
        if (!Permisos::esSuper()) {
            throw new \yii\web\ForbiddenHttpException('Acceso denegado.');
        }

        $usuarios = Usuarios::find()
            ->where(['tipo_usuario' => ['VINCULACION', 'MINIVINCULACION']])
            ->all();

        return $this->render('panel-permisos', [
            'usuarios' => $usuarios,
        ]);
    }

    public function actionCambiarRol($id, $nuevoRol)
    {
        if (!Permisos::esSuper()) {
            throw new \yii\web\ForbiddenHttpException('Acceso denegado.');
        }

        $usuario = Usuarios::findOne($id);
        $usuario->tipo_usuario = $nuevoRol;
        $usuario->save();

        return $this->redirect(['panel-permisos']);
    }

}