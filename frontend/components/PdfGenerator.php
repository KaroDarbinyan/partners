<?php


namespace frontend\components;

use common\models\PropertyDetails;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;
use setasign\Fpdi\PdfParser\PdfParserException;
use Yii;

class PdfGenerator
{

    private $pdf;
    private $resources;
    private $property;
    private $version;
    private $page_num_style = '<p style="color: {{page_num_color}}; position: absolute; bottom: 15px; right: 35px; width: 20%; text-align: right; font-size: 15px">{{page_num}}</p>';

    /**
     * PdfGenerator constructor.
     * @param PropertyDetails $property
     * @param int $version
     * @throws MpdfException
     */
    public function __construct($property, $version = 1)
    {
        $this->version = $version;
        $this->property = $property;
        $this->resources = $this->getResources();
        $this->pdf = new Mpdf([
            'fontDir' => [
                "{$this->resources['fonts']}/Oswald",
                "{$this->resources['fonts']}/Montserrat",
                "{$this->resources['fonts']}/HelveticaNeue",
                "{$this->resources['fonts']}/Arial",
                "{$this->resources['fonts']}/AGaramondPro-Regular"
            ],
            'fontdata' => [
                'arial' => [
                    'R' => 'arial.ttf'
                ],
                'oswald-bold' => [
                    'R' => 'Oswald-Bold.ttf'
                ],
                'oswald-medium' => [
                    'R' => 'Oswald-Medium.ttf'
                ],
                'oswald-light' => [
                    'R' => 'Oswald-Light.ttf'
                ],
                'montserrat-bold' => [
                    'R' => 'Montserrat-Bold.ttf'
                ],
                'montserrat-medium' => [
                    'R' => 'Montserrat-Medium.ttf'
                ],
                'montserrat-light' => [
                    'R' => 'Montserrat-Light.ttf'
                ],
                'helvetica-neue-bold' => [
                    'R' => 'HelveticaNeue-Bold.ttf'
                ],
                'helvetica-neue-light' => [
                    'R' => 'HelveticaNeue-Light.ttf'
                ],
                'a-garamond-pro-regular' => [
                    'R' => 'AGaramondPro-Regular.ttf'
                ]
            ],
            'default_font' => 'frutiger',
        ]);
        $this->pdf->showImageErrors = true;
        $this->pdf->SetTitle($this->property->adresse);

    }

    /**
     * output pdf file
     * @throws MpdfException
     * @throws PdfParserException
     */
    public function generate()
    {
        foreach ($this->resources["data"] as $item) {
           if ($item['show']) {
               $pageCount = $this->pdf->SetSourceFile("{$this->resources['templates']}/page_{$item['page']}.pdf");
               for ($page = 1; $page <= $pageCount; $page++) {
                   $this->pdf->AddPageByArray([
                       'orientation' => $item["orientation"],
                       'sheet-size' => $item["sheet-size"],
                   ]);
                   $template = $this->pdf->ImportPage($page);
                   $this->pdf->UseTemplate($template);
               }
               $this->pdf->WriteHTML(str_replace(['{{page_num_color}}', '{{page_num}}'], [$item['page_num_color'], $item['page_num']], $this->page_num_style));
               if ($item['htmlContent']) $this->htmlContent($item);
           }
        }

        $this->pdf->Output("{$this->property->adresse}.pdf", Destination::INLINE);

    }


    /**
     * @param $config
     * @throws MpdfException
     */
    public function htmlContent($config)
    {
        $html = Yii::$app->view->render("{$this->resources['views']}/page_{$config['page']}", ['property' => $this->property]);
        $this->pdf->WriteHTML($html);
    }

    /**
     * @return array
     */
    private function getResources(): array
    {
        $dir = "pdf/template_{$this->version}";
        $assets = Yii::getAlias('@frontend') . '/web/befaring-assets';
        $viewPath = Yii::$app->viewPath . "/befaring/pdf/template_{$this->version}";

        return [
            'views' => "/befaring/pdf/template_{$this->version}",
            'fonts' => "{$assets}/pdf/fonts",
            'templates' => "{$assets}/{$dir}",
            'data' => include("{$viewPath}/data.php")
        ];
    }

}