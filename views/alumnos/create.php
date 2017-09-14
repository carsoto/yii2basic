<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h3>Crear Alumno</h3>
<h4><?= $msg; ?></h4>

<?php 
    $form = ActiveForm::begin([
            "method" => "post",
            "enableClientValidation" => true,
    ]);
?>

<div class="form-group">
    <?= $form->field($model, "nombre")->input("text"); ?>   
</div>

<div class="form-group">
    <?= $form->field($model, "apellidos")->input("text"); ?>   
</div>

<div class="form-group">
    <?= $form->field($model, "clase")->input("text"); ?>   
</div>

<div class="form-group">
    <?= $form->field($model, "nota_final")->input("text"); ?>   
</div>

<?= Html::submitButton("Crear", ["class" => "btn btn-primary"]); ?>

<?php $form->end(); ?>