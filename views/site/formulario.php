<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<h3>Formulario de Ejemplo</h3>
<h4><?= $mensaje; ?></h4>
<?php
    echo Html::beginForm(
        Url::toRoute("site/request"),
        "GET",
        array(
            "class" => "form-inline",
        )
    );
?>

<div class="form-group">
    <?= Html::label("Introduce tu nombre", "nombre"); ?>
    <?= Html::textInput("nombre", null, array("class" => "form-control input-sm")); ?>
</div>

<?php 
    echo Html::submitInput("Enviar", array("class" => "btn btn-sm btn-success"));
?>

<?php
    echo Html::endForm();
?>