<?php

namespace frontend\controllers;

use common\models\Boligvarsling;
use common\models\Forms;
use common\models\FreeText;
use common\models\Image;
use common\models\PropertyDetails;
use Mpdf\Mpdf;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DwellingController extends Controller
{
    /**
     * Detailed display of property.
     *
     * @deprecated
     *
     * @param $id
     * @param bool $forceView
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDetail($id, $forceView = false)
    {
        $property = PropertyDetails::find()
            ->filterWhere(['oppdragsnummer' => $id])
            ->orFilterWhere(['id' => $id])
            ->one();

        if (!$property) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->redirect($property->path(), 301);
    }

    /**
     * Display Employee page related to specific property
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionVisning($id)
    {
        Yii::$app->view->params['page'] = 'ansatte_per_kontrol';
        Yii::$app->view->title = 'Visningsliste';
        Yii::$app->view->params['header'] = 'LA VÅR BOLIGSØKER FINNE <b>RETT BOLIG TIL DEG</b>';
        $this->layout = 'page_only';

        $model = new Forms();

        /** @var PropertyDetails $property */
        $property = PropertyDetails::find()
            ->joinWith(['user'])
            ->select([
                'property_details.id',
                'property_details.kommuneomraade',
                'property_details.prisantydning',
                'property_details.adresse',
                'property_details.overskrift',
                'ansatte1_id',
            ])
            ->where(['or',
                ['property_details.id' => $id,],
                ['property_details.oppdragsnummer' => $id,],
            ])
            ->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1
            ])
            ->one();

        if (!$property){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $broker = $property->user;
        $model->target_id = $property->id;
        $model->broker_id = $property->ansatte1_id;
        $model->i_agree = true;
        return $this->render('visning', compact('model', 'broker', 'property'));
    }


    /**
     * Display sold property.
     *
     * @param $id
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSold($id)
    {
        Yii::$app->view->params['page'] = 'leilighet-solgt';
        Yii::$app->view->title = 'Leilighet Solgt';
        Yii::$app->view->params['header'] = '';

        /** @var PropertyDetails $property */
        $property = PropertyDetails::find()
            ->joinWith('user')
            ->joinWith(['images' => function (ActiveQuery $query) {
                $query->orderBy(['image.nr' => SORT_ASC]);
            }])
            ->where(['or', ['property_details.id' => $id], ['property_details.oppdragsnummer' => $id]])
            ->one();

        if (!$property) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($property->solgt == 0) {
            return $this->redirect($property->path());
        }

        $model = new Forms();

        $broker = $property->user;
        $model->target_id = $property->id;
        $model->broker_id = $broker->web_id;
        return $this->render('sold', compact('property', 'broker', 'model'));
    }

    /**
     * Get a pdf for the property.
     *
     * @param $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function actionPdf($id)
    {
        /** @var PropertyDetails $property */
        $property = PropertyDetails::find()
            ->where(['or',
                ['oppdragsnummer' => $id],
                ['id' => $id]
            ])
            ->one();

        if (!$property) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!$pdf = $property->getPdfLinkSalgsoppgave()) {
            return $this->redirect($property->path());
        }

        return $this->redirect($pdf);
    }

    /**
     * Show boligvarsling page.
     *
     * @return string|mixed
     */
    public function actionForm()
    {
        Yii::$app->view->params['page']   = 'boligvarsling';
        Yii::$app->view->title            = 'Boligsøker';
        Yii::$app->view->params['header'] = 'BOLIGER <b>SOM KOMMER FOR SALG</b>';

        $formModel = new Boligvarsling;
        $request = Yii::$app->request;

        if ($request->isAjax && $request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($formModel->load($request->post())) {
                if ($priceRange = $request->post('price_range')) {
                    list ($from, $to) = explode(';', $priceRange);

                    $formModel->cost_from = $from;
                    $formModel->cost_to = $to;
                }

                if ($areaRange = $request->post('area_range')) {
                    list ($from, $to) = explode(';', $areaRange);

                    $formModel->area_from = $from;
                    $formModel->area_to = $to;
                }
            }

            if (!$formModel->validate()) {
                return $formModel->getErrors();
            }

            $mapCircle = $request->post('circle');

            $mapEnabled = ArrayHelper::getValue($mapCircle, 'enable');

            if ($mapEnabled) {
                $formModel->map_lat = ArrayHelper::getValue($mapCircle, 'lat');
                $formModel->map_lng = ArrayHelper::getValue($mapCircle, 'lon');
                $formModel->map_radius = ArrayHelper::getValue($mapCircle, 'radius');
            }

            Boligvarsling::updateAll(
                ['subscribe' => false],
                ['email' => $formModel->email]
            );

            if (!empty($formModel->property_type)) {
                if (in_array('Alle Tomt', $formModel->property_type)) {
                    $homestead = $request->post('tomt', []);

                    if (empty($homestead)) {
                        $formModel->property_type = array_merge($formModel->property_type, ['Tomt', 'Hytte-tomt']);
                    } else {
                        $formModel->property_type = array_merge($formModel->property_type, $homestead);
                    }
                }

                $formModel->property_type = array_values(array_diff($formModel->property_type, ['Alle Tomt']));
                $formModel->property_type = Json::encode($formModel->property_type);
            }

            if (!empty($formModel->region)) {
                $formModel->region = Json::encode(array_filter($formModel->region));
            }

            if (!empty($formModel->rooms)) {
                $formModel->rooms = Json::encode($formModel->rooms);
            }

            if (!empty($formModel->criterions)) {
                $formModel->criterions = Json::encode($formModel->criterions);
            }

            $formModel->save(false);

            return [
                'success' => true,
                'message' => 'Du vil få epost med boliger som passer ditt søk.'
            ];
        }

        $types = PropertyDetails::find()
            ->getTypes()
            ->asArray()
            ->all();

        $areas = PropertyDetails::find()->getAreas()['areas'];

        return $this->render('form', compact('types', 'areas', 'formModel'));
    }

    /**
     * Generate PDF file.
     *
     * @param int $id
     *
     * @return string
     *
     * @throws \Mpdf\MpdfException
     */
    public function actionGenerate($id)
    {
        $property = PropertyDetails::find()
            ->with(['user', 'freeTexts', 'images' => function(ActiveQuery $query) {
                $query->orderBy(['nr' => SORT_ASC]);
            }])
            ->where(['id' => $id])
            ->one();

        $description = '';
        $images = [];
        $planImage = null;
        $planDescription = null;

        /** @var FreeText $text */
        foreach ($property->freeTexts as $text) {
            if (strpos($text->overskrift, 'Beskrivelse') !== false) {
                $description = $text->htmltekst;
            }

            if (strpos($text->overskrift, 'Innhold') !== false) {
                $planDescription = $text->htmltekst;
            }
        }

        /** @var Image $image */
        foreach ($property->images as $image) {
            if (strpos($image->overskrift, 'Plan') !== false) {
                $planImage = $image->urloriginalbilde;
            } else {
                $images[] = [
                    'url' => $image->urloriginalbilde,
                    'text' => $image->overskrift
                ];
            }
        }

        $html = $this->renderPartial('pdf', compact(
            'property',
            'description',
            'images',
            'planImage',
            'planDescription'
        ));

        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [180, 260],
            'orientation' => 'P',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'defaultfooterfontstyle' => 'normal',
            'defaultfooterline' => 0,
            'default_font_size' => 12,
            'default_font' => 'FreeSans',
        ]);

        $pdf->showImageErrors = true;
        $pdf->autoPageBreak = false;

        $pdf->SetHTMLFooter('<div class="footer">{PAGENO}</div>','1');

        $pdf->WriteHTML($html);

        return $pdf->Output();
    }

}
