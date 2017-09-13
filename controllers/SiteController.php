<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use app\models\ValidarFormularioAjax;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    public function actionFormulario($mensaje = null){
        return $this->render('formulario', array("mensaje" => $mensaje));
    }

    public function actionRequest(){
        $mensaje = null;
        if (isset($_REQUEST['nombre'])) {
            $mensaje = "Bien, haz enviado tu nombre correctamente ".$_REQUEST['nombre'];
        }
        $this->redirect(array("site/formulario", "mensaje" => $mensaje));
    }

    public function actionValidarformulario(){
        $model = new ValidarFormulario;

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->validate()) {
                //Correct
            } else{
                $model->getErrors();
            }
        }
        return $this->render('validarformulario', array("model" => $model));
    }

    public function actionValidarformularioajax(){
        $model = new ValidarFormularioAjax;
        $msg = null;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->validate()) {
                //Correct
                $msg = "Enhorabuena, formulario enviado correctamente";
                $model->nombre = null;
                $model->email = null; 

            } else{
                $model->getErrors();
            }
        }

        return $this->render('validarformularioajax', array("model" => $model, "mensaje" => $msg));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
