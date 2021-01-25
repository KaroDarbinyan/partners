<?php

namespace frontend\controllers;

use common\components\SnsComponent;
use common\models\Criterias;
use common\models\Forms;
use common\models\PropertyDetails;
use common\models\Vindulosning;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

final class BuyController extends Controller
{

    public function behaviors()
    {
        $this->enableCsrfValidation = false;

        return parent::behaviors();
    }


    /**
     * @param bool $archives
     * @param bool $newBuildings
     * @return array|string
     */
    public function actionDwelling($archives = false, $newBuildings = false)
    {
        Yii::$app->view->params['page'] = $archives ? 'eiendommer archives' : 'eiendommer';
        Yii::$app->view->title = $archives ? 'Eiendommer Archives' : 'Eiendommer';
        Yii::$app->view->params['header'] = 'SØK ETTER <b>DITT HJEM</b>';

        $maxMin = PropertyDetails::find()
            ->select([
//                'MAX(price) as maxColumn',
//                'MIN(price) as minColumn',
                'COUNT(*) as count'])
            ->asArray()
            ->one();

        $maxMin['maxColumn'] = 10000000;
        $maxMin['minColumn'] = 100000;

        $maxMinArea = [
            'minArea' => 0,
            'maxArea' => 300
        ];

        $propertiesData = PropertyDetails::find()
            ->getFiltered(30, null, null, $archives, $newBuildings);

        $propertiesData['newBuildings'] = $newBuildings;

        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $html = $this->renderPartial('@frontend/views/properties/list.php',
                $propertiesData
            );

            return [
                'html' => $html,
                'count' => $propertiesData['count']
            ];
        }

        $getAreas = $this->getAreas($newBuildings);
        $count = $getAreas['count'];
        $areas = $getAreas['areas'];

        if (!is_null($propertiesData['gettingAreas'])) {
            foreach ($propertiesData['gettingAreas'] as $area => $children) {
                if (isset($areas[$area])) {
                    $areas[$area]['checked'] = true;

                    if (is_array($children)) {
                        foreach ($children as $child) {
                            if (isset($areas[$area]['area'][$child])) {
                                $areas[$area]['area'][$child]['checked'] = true;
                            }
                        }
                    }
                }
            }
        }

        $types = PropertyDetails::find()
            ->getTypes()
            ->asArray()
            ->all();

        if (!is_null($propertiesData['gettingTypes'])) {
            foreach ($propertiesData['gettingTypes'] as $type) {
                if (isset($types[$type])) {
                    $types[$type]['checked'] = true;
                }
            }
        }

        $typesOfOwnership = PropertyDetails::find()
            ->getTypesOfOwnership()
            ->asArray()
            ->all();

        if (!is_null($propertiesData['gettingTypesOfOwnership'])) {
            foreach ($propertiesData['gettingTypesOfOwnership'] as $type) {
                if (isset($typesOfOwnership[$type])) {
                    $typesOfOwnership[$type]['checked'] = true;
                }
            }
        }

        $roomCounts = PropertyDetails::find()
            ->select(['soverom', 'COUNT(*) as count'])
            ->groupBy(['soverom'])
            ->orderBy(['soverom' => SORT_ASC])
            ->indexBy(['soverom'])
            ->limit(5)
            ->getActive()
            ->asArray()
            ->all();

        if (!is_null($propertiesData['gettingRooms'])) {
            foreach ($propertiesData['gettingRooms'] as $key => $room) {
                if (isset($roomCounts[$room])) {
                    $roomCounts[$room]['checked'] = true;
                }
            }
        }

        $criterions = Criterias::find()
            ->select(['navn', 'iadnavn'])
            ->where(['id_typer' => [230, 231, 233, 244]])
            ->groupBy(['id_typer'])
            ->orderBy(['navn' => SORT_ASC])
            ->indexBy('iadnavn')
            ->asArray()
            ->all();

        if (!is_null($propertiesData['criterions'])) {
            foreach ($propertiesData['criterions'] as $criterion) {
                if (isset($criterions[$criterion])) {
                    $criterions[$criterion]['checked'] = true;
                }
            }
        }

        if (is_null($propertiesData['price']['start'])) {
            $propertiesData['price']['start'] = $maxMin['minColumn'];
        }

        if (is_null($propertiesData['price']['end'])) {
            $propertiesData['price']['end'] = $maxMin['maxColumn'];
        }

        if (is_null($propertiesData['area']['start'])) {
            $propertiesData['area']['start'] = $maxMinArea['minArea'];
        }

        if (is_null($propertiesData['area']['end'])) {
            $propertiesData['area']['end'] = $maxMinArea['maxArea'];
        }

        $filters = [
            'price_min' => $maxMin['minColumn'],
            'price_max' => $maxMin['maxColumn'],
            'price_from' => $propertiesData['price']['start'],
            'price_to' => $propertiesData['price']['end'],
            'area_min' => $maxMinArea['minArea'],
            'area_max' => $maxMinArea['maxArea'],
            'area_from' => $propertiesData['area']['start'],
            'area_to' => $propertiesData['area']['end'],
            'areas' => $areas,
            'types' => $types,
            'types_of_ownership' => $typesOfOwnership,
            'rooms' => $roomCounts,
            'criterions' => $criterions,
            'archives' => $archives === 'true' || $archives === 'on',
            'count' => $count,
            'text' => $propertiesData['text'],
        ];

        return $this->render('dwelling', compact('propertiesData', 'filters', 'count'));
    }

    /**
     * @return string
     */
    public function actionUserDwellingParameters()
    {
        Yii::$app->view->params['page'] = 'boligvarsling';
        Yii::$app->view->title = 'Boligsøker';
        Yii::$app->view->params['header'] = 'AUTOMATISK <b>BOLIGVARSLING</b>';

        $types = PropertyDetails::find()
            ->getTypes()
            ->asArray()
            ->all();

        $areas = $this->getAreas();
        $areas = $areas['areas'];

        $formModel = new Forms();

        return $this->render(
            'user-dwelling-parameters',
            compact('types', 'areas', 'formModel')
        );
    }

    public function actionFilterNotification()
    {
        if (Yii::$app->request->isAjax) {
            $model = new FilterNotification();
            if ($model->load(Yii::$app->request->post())) {
                $model->phone = substr($model->phone, 0, 3) !== "+47" ? $model->phone = '+47' . $model->phone : $model->phone;
                if ($model->save()) {
                    $smsSender = new SnsComponent();
                    $adminPhone = '+4796737776';
                    $smsSender->publishSms(
                        "Vi skal kontakte deg snart",
                        $model->phone
                    );
                    $smsSender->publishSms(
                        "
                            Form submiting --> $model->type,
                            Phone number --> $model->phone,
                            Sms Result --> success
                            ",
                        $adminPhone
                    );
                    return Json::encode('success');
                } else {
                    return Json::encode($model->getErrors());
                }
            }
        }
        throw new HttpException(404, 'Not found');
    }

    public function actionArchives()
    {


        return $this->render('archives');
    }

    private function getAreas($newBuildings = false)
    {
        $areas = PropertyDetails::find()->select([
            'id',
            'kommuneomraade as area',
            'poststed',
            'kommunenavn',
            'fylkesnavn as omrade',
            'IFNULL(oppdragsnummer__prosjekthovedoppdrag, id) as unique_group'
        ]);

        if ($newBuildings) {
            $areas->andWhere(['tinde_oppdragstype' => 'Prosjekt']);
        } else {
            $areas->andWhere(['not', ['tinde_oppdragstype' => 'Prosjekt']]);
        }

        $areas = $areas->andWhere(['not', ['fylkesnavn' => null, 'area' => null]])
            ->andWhere(['>', 'LENGTH(fylkesnavn)', 0])
            ->andWhere([
                'arkivert' => 0,
                'vispaafinn' => -1
            ])
            ->andWhere(['property_details.is_visible' => 1])
            ->andWhere(['or',
                ['solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
//            ->andWhere(['or',
//                ['=', 'utlopsdato', 0],
//                ['>', 'utlopsdato', time()]
//            ])
            ->andWhere(['or',
                ['and', ['in', 'fylkesnavn', ['Oslo']], ['not', ['area' => null]]],
                ['not in', 'fylkesnavn', ['Oslo']]
            ])
            ->groupBy(['unique_group'])
            ->asArray()
            ->all();

        $areas = ArrayHelper::getValue($areas, function ($areas) {
            $temp = [];
            $count = 0;
            foreach ($areas as $area) {
                $count++;

                if (!isset($temp[$area['omrade']])) {
                    $temp[$area['omrade']] = [
                        'omrade' => $area['omrade'],
                        'count' => 0,
                        'area' => []
                    ];
                }

                $temp[$area['omrade']]['count'] += 1;

                if ($area['omrade'] !== 'Oslo') {
                    $area['area'] = $area['kommunenavn'];
                }

                if ($area['area']) {
                    if (!isset($temp[$area['omrade']]['area'][$area['area']])) {
                        $temp[$area['omrade']]['area'][$area['area']]['count'] = 0;
                    }

                    $temp[$area['omrade']]['area'][$area['area']]['count'] += 1;
                }

                ksort($temp[$area['omrade']]['area']);
            }

            ArrayHelper::multisort($temp, 'omrade', SORT_ASC);

            return [
                'areas' => $temp,
                'count' => $count
            ];
        });

        return $areas;

    }


    /**
     * @param bool $archives
     * @param bool $newBuildings
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionReklame($archives = false, $newBuildings = false)
    {
        Yii::$app->view->params['page'] = $archives ? 'eiendommer archives' : 'eiendommer';
        Yii::$app->view->title = $archives ? 'Eiendommer Archives' : 'Eiendommer';
        Yii::$app->view->params['header'] = 'SØK ETTER <b>DITT HJEM</b>';

        $view = Yii::$app->request->get("view");
        $id = Yii::$app->request->get("id");

        if (!$view || (($view !== "carousel") && ($view !== "list"))) throw new NotFoundHttpException();

        if ($id) {
            if ($vindulosning = Vindulosning::findOne(["view" => $view, "id" => $id])) {
                $propertiesData["properties"] = PropertyDetails::find()->where("id IN({$vindulosning->property_ids})")->all();
                return $this->render("/properties/vindulosning/{$view}", compact('propertiesData', 'vindulosning'));
            }
            throw new NotFoundHttpException();
        }

        $limit = 30;
        $vindulosning = new Vindulosning(["column" => 6, "view" => $view]);
        $propertiesData = PropertyDetails::find()
            ->getFiltered($limit, null, null, $archives, $newBuildings);

        if ($view === "carousel") {
            $vindulosning->column = 12;
            $limit = intval($propertiesData["count"]);
            $propertiesData = PropertyDetails::find()
                ->getFiltered($limit, null, null, $archives, $newBuildings);

            $propertiesData["properties"] = count($propertiesData["properties"]) <= 40
                ? $propertiesData["properties"]
                : array_slice($propertiesData["properties"], rand(0, $limit - 40), 40);

        }

        return $this->render("/properties/vindulosning/{$view}", compact('propertiesData', 'vindulosning'));


    }

}