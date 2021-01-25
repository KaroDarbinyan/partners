<?php
/**
 * Created by PhpStorm.
 * User: FSW10
 * Date: 14.03.2019
 * Time: 15:12
 */

namespace frontend\controllers;


use common\components\SnsComponent;
use common\models\AllPostNumber;
use common\models\FilterNotification;
use common\models\Forms;
use common\models\Image;
use common\models\Property;
use common\models\PropertyDetails;
use frontend\assets\AppAsset;
use frontend\assets\BefaringAsset;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 *
 * @property mixed $areas
 */
class CompareController extends Controller
{

    public function behaviors()
    {
        $this->enableCsrfValidation = false;
        return parent::behaviors();
    }


    public function actionDwelling($archives = false)
    {
        Yii::$app->view->params['page'] = $archives ? 'eiendommer archives' : 'eiendommer';
        Yii::$app->view->title =  $archives ? 'Eiendommer Archives': 'Eiendommer';
        Yii::$app->view->params['header'] = 'SØK ETTER <b>DITT HJEM</b>';

        $maxMin = Property::find()
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

        $propertiesData = Property::getFilteredProperties();

        $getAreas = $this->getAreas();
        $count = $getAreas['count'];
        $areas = $getAreas['areas'];


        if(!is_null($propertiesData['gettingAreas'])) {
            foreach ($propertiesData['gettingAreas'] as $area) {
                if (isset($areas[$area])) {
                    $areas[$area]['checked'] = true;
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
            ->select(['soverom'])
            ->where(['IS NOT', 'soverom', null])
            ->groupBy(['soverom'])
            ->orderBy(['soverom' => SORT_ASC])
            ->indexBy(['soverom'])
            ->asArray()
            ->all();

        if (!is_null($propertiesData['gettingRooms'])) {
            foreach ($propertiesData['gettingRooms'] as $key => $room) {
                if (isset($roomCounts[$room])) {
                    $roomCounts[$room]['checked'] = true;
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

        $filter_notification = new FilterNotification();
        return $this->render('dwelling',
            compact(
                'propertiesData',
                'maxMin',
                'maxMinArea',
                'filter_notification',
                'areas',
                'types',
                'typesOfOwnership',
                'archives',
                'count'
            )
        ); //, 'price'
    }

    /**
     * @param int $limit
     * @param null $offset
     * @return mixed
     */
    public function actionGetMoreProperties($limit = 20, $offset = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $propertiesData = Property::getFilteredProperties($limit, $offset);

        $properties = $propertiesData['properties'];
        $pages = $propertiesData['pages'];

        $data['finish_cards_load'] = false;
        if (count($properties) <= $limit) $data['finish_cards_load'] = true;
        else array_pop($properties);

        $data['cards_html'] = $this->renderPartial('building-card', compact('properties', 'pages'));
        $data['cards_count'] = $propertiesData['count'];
        return $data;
    }


    /**
     * @return string
     */
    public function actionUserDwellingParameters()
    {
        Yii::$app->view->params['page']   = 'boligvarsling';
        Yii::$app->view->title            = 'Boligsøker';
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

    public function actionApps()
    {
        Yii::$app->view->params['page'] = 'applikasjon';
        Yii::$app->view->title = 'Applikasjon';
        Yii::$app->view->params['header'] = 'LA VÅR BOLIGSØKER FINNE <b>RETT BOLIG TIL DEG</b>';

        return $this->render('apps');
    }

    public function actionFilterNotification()
    {
        if (Yii::$app->request->isAjax) {
            $model = new FilterNotification();
            if ($model->load(Yii::$app->request->post())) {
                $model->phone = substr($model->phone, 0, 3) !== "+47"? $model->phone = '+47' . $model->phone:$model->phone;
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

    private function getAreas()
    {
        $areas = PropertyDetails::find()->select([
            'id',
            'area',
            'fylkesnavn as omrade'
        ])->andWhere(['not', ['fylkesnavn' => null, 'area' => null]])
            ->andWhere([
                'arkivert' => 0,
                'vispaafinn' => -1
            ])
            ->andWhere(['or',
                ['solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->andWhere(['or',
                ['=', 'utlopsdato', 0],
                ['>', 'utlopsdato', time()]
            ])
            ->andWhere(['or',
                ['and', ['in', 'fylkesnavn', ['Oslo']], ['not', ['area' => null]]],
                ['not in', 'fylkesnavn', ['Oslo']]
            ])
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
                if ($area['area']) {
                    if (!isset($temp[$area['omrade']]['area'][$area['area']])) {
                        $temp[$area['omrade']]['area'][$area['area']] = 0;
                    }
                    $temp[$area['omrade']]['area'][$area['area']] += 1;
                }
            }

            ArrayHelper::multisort($temp, 'omrade', SORT_ASC);

            return [
                'areas' => $temp,
                'count' => $count
            ];
        });

        return $areas;

    }


    public function actionCompare()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException("Siden finnes ikke.");
        }

        Yii::$app->view->registerCssFile('https://unpkg.com/flickity@2/dist/flickity.css', ['depends' => AppAsset::className()]);
        Yii::$app->view->registerJsFile('https://unpkg.com/flickity@2/dist/flickity.pkgd.js', ['depends' => AppAsset::className()]);

        /*$images = Image::find()->where(['propertyDetailId' => $id])->all();
        return $this->renderAjax('oppdrag/detaljer/_bilder', compact('images'));*/
        $ids = Yii::$app->request->get()["ids"];
        $property_details = PropertyDetails::find()->where(["in", "property_details.id", $ids])->all();

        return $this->renderAjax('_compare-modal', compact("property_details"));

    }

}