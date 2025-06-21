<?php
use yii\helpers\Html; 
?>

<?php if ($cartas): ?> 
    <?= $this->render('tabla', [
        'cartas' => $cartas,
        'tipo' => 'terminacion' // Pasar el tipo correcto
    ]) ?>
<?php else: ?> 
    <p>No se encontró información.</p>
<?php endif; ?>