<?php
use yii\helpers\Html; 
?>

<?php if ($cartas): ?> 
    <?= $this->render('tabla', [
        'cartas' => $cartas,
        'tipo' => 'datosGenerales' // Pasar el tipo correcto
    ]) ?>
<?php else: ?> 
    <p>No se encontró información.</p>
<?php endif; ?>