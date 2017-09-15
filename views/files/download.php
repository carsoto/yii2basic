<?php 

use yii\helpers\Url; 

?>

<?php 
	if (Yii::$app->session->hasFlash('errordownload')): 
?>
		<strong class="label label-danger">¡Ha ocurrido un error al descargar el archivo!</strong>

<?php 
	else: 
?>
		<br><a href="<?= Url::toRoute(["files/download", "file" => "archivo1.pdf"]) ?>">archivo1.pdf</a>
		<br><a href="<?= Url::toRoute(["files/download", "file" => "archivo2.pdf"]) ?>">archivo2.pdf</a>
<?php endif; ?>
