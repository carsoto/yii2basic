<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h3>Validar Formulario AJAX</h3>
<h4><?= $mensaje; ?></h4>
<?php

	$form = ActiveForm::begin(array(
			"method" => "POST",
			"id" => "formulario",
			"enableClientValidation" => false,
			"enableAjaxValidation" => true
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