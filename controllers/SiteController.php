<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\authclient\ClientInterface;
use app\models\Usuarios;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        
        if (!isset($attributes['email']) || !isset($attributes['id'])) {
            Yii::$app->session->setFlash('error', 'No se pudo obtener la información necesaria del proveedor.');
            return $this->redirect(['site/login']);
        }
        
        $email = $attributes['email'];
        $googleId = $attributes['id'];
    
        $usuario = Usuarios::findOne(['correo' => $email]);
    
        if (!$usuario) {
            Yii::$app->session->setFlash('error', 'El correo no está registrado en el sistema.');
            return $this->redirect(['site/login']);
        }
    
        if (empty($usuario->token)) {
            $usuario->token = $googleId;
            if (!$usuario->save()) {
                Yii::$app->session->setFlash('error', 'Error al guardar el token.');
                return $this->redirect(['site/login']);
            }
        }
    
        // Inicia sesión
        Yii::$app->user->login($usuario);
        // 🔥 **GUARDA EL ID DEL USUARIO EN LA SESIÓN** 🔥
        Yii::$app->session->set('user_id', $usuario->id);
    
        // Verificamos el tipo de usuario y redirigimos
        if ($usuario->tipo_usuario == 'ESTUDIANTE') {
            return $this->redirect(['/alumno']);
        } elseif ($usuario->tipo_usuario == 'VINCULACION') {
            return $this->redirect(['/vinculacion']);
        }
    
        // Si el tipo de usuario no es reconocido, lo deslogueamos
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            // Obtener el usuario autenticado
            $usuario = Yii::$app->user->identity;

            // Verificar el tipo de usuario y redirigir según corresponda
            if ($usuario->tipo_usuario == 'ESTUDIANTE') {
                return $this->redirect(['/alumno']); // Redirige a la vista de alumno
            } elseif ($usuario->tipo_usuario == 'VINCULACION') {
                return $this->redirect(['/vinculacion']); // Redirige a la vista de vinculación
            }

            // Si el usuario no es de tipo "alumno" ni "vinculacion", redirigirlo al login
            Yii::$app->user->logout();
            return $this->redirect(['site/login']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Obtener el usuario autenticado
            $usuario = Yii::$app->user->identity;

            // Verificar el tipo de usuario
            if ($usuario->tipo_usuario == 'alumno') {
                return $this->redirect(['/alumno']);
            } elseif ($usuario->tipo_usuario == 'vinculacion') {
                return $this->redirect(['/vinculacion']);
            }

            // Si el tipo de usuario no es reconocido, desloguear y redirigir a login
            Yii::$app->user->logout();
            return $this->redirect(['site/login']);
        }

        return $this->render('login', ['model' => $model]);
    }



    public function actionLogout()
    {
        // Cerrar sesión en la aplicación
        Yii::$app->user->logout(true);
    
        // Verifica si hay un cliente OAuth en la sesión
        if (Yii::$app->session->has('authClient')) {
            $clientName = Yii::$app->session->get('authClient');
    
            // Redirigir al usuario a la página de cierre de sesión del proveedor OAuth
            switch ($clientName) {
                case 'google':
                    return $this->redirect('https://accounts.google.com/Logout');
                    break;
                // Agrega más casos para otros proveedores OAuth
                default:
                    return $this->redirect(['site/login']);
            }
        }
    
        // Redirigir al usuario a la página de login
        return $this->redirect(['site/login']);
    }

}
