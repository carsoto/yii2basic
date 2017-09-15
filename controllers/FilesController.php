<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\FormUpload;
use yii\web\UploadedFile;


class FilesController extends Controller
{    
    public function actionUpload()
    {
        $model = new FormUpload;
        $msg = null;

        if ($model->load(Yii::$app->request->post()))
        {
            $model->file = UploadedFile::getInstances($model, 'file');

            if ($model->file && $model->validate()) {
                foreach ($model->file as $file) {
                    $file->saveAs('files_uploaded/' . $file->baseName . '.' . $file->extension);
                    $msg = "<p><strong class='label label-info'>Enhorabuena, subida realizada con éxito</strong></p>";
                }
            }
        }
        return $this->render("upload", ["model" => $model, "msg" => $msg]);
    }

    private function downloadFile($dir, $file, $extensions=[])
    {
        //Si el directorio existe
        if (is_dir($dir))
        {
            //Ruta absoluta del archivo
            $path = $dir.$file;

            //Si el archivo existe
            if (is_file($path))
            {
                //Obtener información del archivo
                $file_info = pathinfo($path);

                //Obtener la extensión del archivo
                $extension = $file_info["extension"];

                if (is_array($extensions))
                {
                    //Si el argumento $extensions es un array - Comprueba las extensiones permitidas
                    foreach($extensions as $e)
                    {
                        //Si la extension es correcta
                        if ($e === $extension)
                        {
                            //Procedemos a descargar el archivo - Definir headers
                            $size = filesize($path);
                            header("Content-Type: application/force-download");
                            header("Content-Disposition: attachment; filename=$file");
                            header("Content-Transfer-Encoding: binary");
                            header("Content-Length: " . $size);
                            
                            // Descargar archivo
                            readfile($path);

                            //Correcto
                            return true;
                        }
                    }
                }
            }
        }

        //Ha ocurrido un error al descargar el archivo
        return false;
    }

    public function actionDownload()
    {
        if (Yii::$app->request->get("file"))
        {
            //Si el archivo no se ha podido descargar downloadFile($dir, $file, $extensions=[])
            if (!$this->downloadFile("files_uploaded/", Html::encode($_GET["file"]), ["pdf", "txt", "doc"]))
            {
                //Mensaje flash para mostrar el error
                Yii::$app->session->setFlash("errordownload");
            }
        }
        return $this->render("download");
    }
}