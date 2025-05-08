<?php
use yii\helpers\Html; 

function traducirMes($fechaIngles) {
    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];
    
    foreach ($meses as $en => $es) {
        $fechaIngles = str_replace($en, $es, $fechaIngles);
    }
    return $fechaIngles;
}
?>

<?php if ($cartas): ?> 
    <?= $this->render('tabla', ['cartas' => $cartas]) ?>
<?php else: ?> 
    <p>No se encontró información para el usuario.</p>
<?php endif; ?>

