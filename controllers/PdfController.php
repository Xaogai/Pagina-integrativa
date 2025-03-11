<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function actionPdf()
    {
        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-pdf.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-presentacion');

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-presentacion.pdf', 'I');
    }
}
