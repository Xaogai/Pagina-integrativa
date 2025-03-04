<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf; // Asegúrate de importar la clase correctamente

class PdfController extends Controller
{
    public function actionPdf()
    {
        // Crear instancia de mPDF
        $mpdf = new Mpdf();

        // Contenido del PDF
        $html = '<h1>Hola, este es un PDF en Yii2</h1><p>Generado con mPDF.</p>';

        // Escribir el contenido HTML en el PDF
        $mpdf->WriteHTML($html);

        // Enviar el PDF al navegador
        return $mpdf->Output('documento.pdf', 'I'); // 'I' para mostrar en el navegador
    }
}
