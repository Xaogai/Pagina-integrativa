<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;
use app\models\CartaPresentacion; // Importar el modelo

class PdfController extends Controller
{
    public function actionPdf()
    {
        // Obtener los datos de la tabla "carta_presentacion"
        $cartas = CartaPresentacion::find()
            ->select([
                'carta_presentacion.*',
                'alumnos.nombre AS nombre_alumno',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'alumnos.nss',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar'
            ])
            ->joinWith(['alumno', 'alumno.carrera', 'semestre', 'ciclo'])
            ->asArray()
            ->all();

        // Cargar los archivos CSS
        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-pdf.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        // Renderizar la vista y pasar los datos
        $html = $this->renderPartial('//carta-presentacion', [
            'cartas' => $cartas, // Pasamos las cartas a la vista
        ]);

        // Crear instancia de mPDF
        $mpdf = new Mpdf();

        // Aplicar CSS
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        // Escribir el HTML en el PDF
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Mostrar el PDF en el navegador
        return $mpdf->Output('carta-presentacion.pdf', 'I');
    }
}