<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\FormAlumnos;
use app\models\Alumnos;


class AlumnosController extends Controller
{    
    public function actionCreate()
    {
        $model = new FormAlumnos;
        $msg = null;
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Alumnos;
                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->clase = $model->clase;
                $table->nota_final = $model->nota_final;
                if ($table->insert())
                {
                    $msg = "Enhorabuena registro guardado correctamente";
                    $model->nombre = null;
                    $model->apellidos = null;
                    $model->clase = null;
                    $model->nota_final = null;
                }
                else
                {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("create", ['model' => $model, 'msg' => $msg]);
    }

    public function actionView()
    {
        $table = new Alumnos;
        $model = $table->find()->all();
        return $this->render("view", ["model" => $model]);
    }
}