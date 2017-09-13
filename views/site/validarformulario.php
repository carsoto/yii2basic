<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h3>Validar Formulario</h3>

<?php

	$form = ActiveForm::begin(array(
				"method" => "POST",
				"enableClientValidation" => true
	));

?>

<div class="form-group">
	<?= $form->field($model, "nombre")->input("text"); ?>
</div>

<div class="form-group">
	<?= $form->field($model, "email")->input("email"); ?>
</div>

<?= Html::submitButton("Enviar", array("class" => "btn btn-primary")); ?>

<?php

	$form->end();
?>