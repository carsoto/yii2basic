<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\FormAlumnos;
use app\models\Alumnos;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;

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
        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
            if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Alumnos::find()
                        ->where(["like", "id_alumno", $search])
                        ->orWhere(["like", "nombre", $search])
                        ->orWhere(["like", "apellidos", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 1,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        else
        {
            $table = Alumnos::find();
            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 1,
                "totalCount" => $count->count(),
            ]);
            $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render("view", ["model" => $model, "form" => $form, "search" => $search, "pages" => $pages]);
    }
}