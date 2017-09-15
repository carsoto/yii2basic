<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
 
<h3><?= $msg ?></h3>
 
<h1>Recuperar Contraseña</h1>
<?php 
	$form = ActiveForm::begin([
	    "method" => "POST",
	    "enableClientValidation" => true,
	]);
?>
 
<div class="form-group">
	<?= $form->field($model, "email")->input("email") ?>  
</div>

<?= Html::submitButton("Recover Password", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>