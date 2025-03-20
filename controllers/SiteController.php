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

    public function actionIndex()
    {
        return $this->render('index'); // Corrección aquí
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
    
        if (!isset($attributes['email'])) {
            Yii::$app->session->setFlash('error', 'No se pudo obtener el correo electrónico.');
            return $this->redirect(['site/login']);
        }
    
        $email = $attributes['email'];
        $usuario = Usuarios::findOne(['correo' => $email]);
    
        if (!$usuario) {
            Yii::$app->session->setFlash('error', 'El correo no está registrado en el sistema.');
            return $this->redirect(['site/login']);
        }

        Yii::$app->session->set('user_id', $usuario->id);
        //Yii::$app->session->set('auth_token', $token);
        Yii::$app->user->login($usuario);

        // Redirigir a la página principal o dashboard
        return $this->redirect(['/alumno']); // O la página que prefieras
    }
    

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/alumno']);
        }
    
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/alumno']);
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

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
