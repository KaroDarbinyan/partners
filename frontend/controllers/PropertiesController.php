<?php

namespace frontend\controllers;

use common\models\Forms;
use common\models\PropertyDetails;
use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PropertiesController extends Controller
{
    /**
     * @param $id
     * @param $slug
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionShow($id, $slug)
    {
        $dayDelay = 30;
        $outdateTime = time() - 60 * 60 * 24 * $dayDelay;

        $property = PropertyDetails::find()
            ->with([
                'user',
                'user2',
                'properties',
                'percentTexts',
                'nabolagsprofilLink',
                'propertyDoc',
                'salgsoppgaveDownloadLink',
                'salgsoppgavePDFDownloadLink',
                'freeTextTitle',
                'propertyVisits' => function (ActiveQuery $query) {
                    $query->where(['>=', 'til', time()]);
                },
                'images' => function (ActiveQuery $images) {
                    $images->orderBy(['image.nr' => SORT_ASC]);
                },
                'freeTexts' => function (ActiveQuery $query) {
                    $query->orderBy(['free_text.nr' => SORT_ASC]);
                }
            ])
            ->joinWith(['propertyAds', 'partner'])
            ->filterWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1
            ])
            ->andFilterWhere(['and',
                ['property_details.oppdragsnummer' => $id],
                ['property_details.is_visible' => 1],
                ['or',
                    'sold_date IS NULL',
                    ['>', 'sold_date', $outdateTime],
                ]
            ]);

        $property = $property->one();

        /** @var PropertyDetails $property */

        if (!$property) {
            throw new NotFoundHttpException('Eiendom ikke funnet!');
        }

        $this->view->title = $property->getSeoTitle();

        if (!$property->slug) {
            $property->saveSlug();
        }

        if ($property->slug !== $slug) {
            return $this->redirect($property->path(), 301);
        }

        $texts = [];
        $totalCost = null;

        $skipText = [
            'Meglers vederlag',
            'Meglers vederlag og utlegg',
            'Avtalt meglervederlag'
        ];

        foreach ($property->freeTexts as $freeText) {
            if (in_array($freeText->overskrift, $skipText)) {
                continue;
            }

            $isTotalCost = in_array($freeText->overskrift, ['Beregnet totalkostnad']);

            if ($freeText->visinettportaler == 0 || $isTotalCost) {
                if ($isTotalCost) {
                    $totalCost = $freeText->htmltekst;
                }
                continue;
            }

            $texts[$freeText->overskrift][] = $freeText;
        }

        $formModel = new Forms;
        $formModel->target_id = $property->id;
        $formModel->broker_id = $property->ansatte1_id;
        $formModel->department_id = $property->avdeling_id;

        if ($property->propertyAds) {
            $property->propertyAds->updateCounters([
                'eiendom_viewings' => 1
            ]);
        }
//        $this->bookingDateInit($property);
        return $this->render('show', compact('property', 'texts', 'totalCost', 'formModel'));
    }

    public function actionLocations()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $query = urlencode(\Yii::$app->request->get('q'));

        $url = "https://kart.finn.no/map/api/geo/query/solr.json?q={$query}&limit=5";

        return json_decode(file_get_contents($url), true);
    }

    private function bookingDateInit(PropertyDetails $property)
    {
        setlocale(LC_ALL, 'nb_NO.UTF-8');
        $items = ['' => 'Velg dato'];
        $options = [];
        $forms = Forms::find()->select(["booking_date", "count(id) as count"])
            ->where(['and', ['target_id' => $property->id], ['is not', 'booking_date', null]])
            ->indexBy("booking_date")->groupBy("booking_date")->asArray()->all();
        if ($property->propertyVisits) {
            foreach ($property->propertyVisits as $propertyVisit) {
                $fra = $propertyVisit->fra;
                while ($fra < $propertyVisit->til) {
                    $optionValue = strftime("%d.%m.%Y.%H:%M", $fra);
                    $items[$optionValue] = strtolower(strftime("%e. %B kl. %H:%M", $fra));
                    if (isset($forms[$optionValue]) && $forms[$optionValue]["count"] > 2)
                        $options[$optionValue] = ['disabled' => true];
                    $fra += 600;
                }
            }
        }

        if (count($items) > 1 && count($options) + 1 !== count($items)) {
            Yii::$app->view->params['booking_field'] = ['items' => $items, 'options' => $options];
        }
    }

}
