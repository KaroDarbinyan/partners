<?php

namespace frontend\controllers;

use common\components\StaticMethods;
use common\models\Department;
use common\models\Property;
use common\models\PropertyDetails;
use common\models\User;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class WebmeglerSearchController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        //TODO:: setup serach input name as static param of controller
        $keyWord = strtolower(Yii::$app->request->get('search'));

        $userTableName = User::tableName();
        $propertiesTableName = PropertyDetails::tableName();
        $propertyQuery = (new Query())
            ->from($propertiesTableName)
            ->where(['not', ['oppdragsnummer' => null,],])
            ->andWhere([
                'solgt' => 0,
                'arkivert' => 0,
                'vispaafinn' => -1,
            ])
            ->andWhere(['or',
                ['=', 'utlopsdato', 0],
                ['>', 'utlopsdato', time()]
            ])
        ;
        $departmentsTableName = Department::tableName();
        $searchItems = [
            "Users" => [
                'query' => (new Query())
                    ->from($userTableName)
                    ->leftJoin(
                        $departmentsTableName,
                        "{$userTableName}.department_id = {$departmentsTableName}.web_id"
                    )->where(['inaktiv_status' => 1]),
                'href'     => "{$departmentsTableName}.id",
                'label'    => "{$userTableName}.navn",
                'type'     => "broker",
                'selector' => "{$userTableName}.navn",
                'isStrict' => false,
                'grouper'  => "{$userTableName}.navn",
                'count'    => -1,
            ],
            "Cities" => [
                'query' => clone $propertyQuery,
                'href'     => "poststed",
                'label'    => "poststed",
                'type'     => "city",
                'selector' => "poststed",
                'isStrict' => false,
                'grouper'  => "poststed",
                'count'    => "SUM(solgt = 0)",
            ],
            "Area" => [
                'query' => clone $propertyQuery,
                'href'     => "area",
                'label'    => "area",
                'type'     => "area",
                'selector' => "area",
                'isStrict' => false,
                'grouper'  => "area",
                'count'    => "SUM(solgt = 0)",
            ],
            "Streets" => [
                'query' => clone $propertyQuery,
                'href'     => "street",
                'label'    => "street",
                'type'     => "street",
                'selector' => "street",
                'isStrict' => false,
                'grouper'  => "street",
                'count'    => "SUM(solgt = 0)",
            ],
            "PostNumber" => [
                'query' => clone $propertyQuery,
                'href'     => "id",
                'label'    => "CONCAT(postnummer, ':', adresse)",
                'type'     => "postNumber",
                'selector' => "postnummer",
                'isStrict' => true,
                'grouper'  => "postnummer",
                'count'    => "SUM(solgt = 0)",
            ],
        ];

        /** @var Query|bool $results */
        $results = false;
        foreach ($searchItems as $key => $item) {
            // TODO :: move loop step to function
            // TODO :: add default value for that function
            /** @var array $item */
            /** @var Query $query */
            $query = $item['query'];
            $select = [
                "{$item['href']} as href",
                "{$item['selector']} as navn",
                "{$item['label']} as label",
                new Expression( "'{$item['type']}' as type"),
                "{$item['grouper']} as grouper",
                new Expression( "{$item['count']} as count"),
            ];
            $query = $query->select($select);
            if($item['isStrict']){
                $query =  $query->andWhere([$item['selector'] => $keyWord]);
            }else{
                $query = $query->andWhere(['or',
                    ['like', $item['selector'], "{$keyWord}%",   false],
                    ['like', $item['selector'], "% {$keyWord}%", false],
                    ['like', $item['selector'], "%-{$keyWord}%", false],
                ]);
            }
            $query =  $query->groupBy([$item['grouper'], $item['selector']]);
            $results = $results ? $results->union($query) : $query;
        }

        $results = $results->all();
        foreach ($results as $i=>$result) {

            $actionName = "urlFor" . ucfirst($result['type']);
            if($result['type'] == User::TYPE_BROKER) {
                $result['href'] = ArrayHelper::getValue($result, 'navn', '');
            }
            $results[$i]['href'] = call_user_func(
                array($this, $actionName),
                $result['href']
            );
        }
        return $this->renderPartial('index', ['list' => $results]);
    }

    /**
     * Generate url from department.id for User's department
     * @param int|string $key
     * @return string Url
     */
    private function urlForBroker($key){
        return '/ansatte/' . $key;
    }

    /**
     * Generate url with street filter for property
     * @param int|string $key
     * @return string Url
     */
    private function urlForStreet($key){
        return Url::to(['/eiendommer', 'street' => $key]);
    }

    /**
     * Generate url with city filter for property
     * @param int|string $key
     * @return string Url
     */
    private function urlForCity($key){
        return Url::to(['/eiendommer', 'city' => $key]);
    }

    /**
     * Generate url with area filter for property
     * @param int|string $key
     * @return string Url
     */
    private function urlForArea($key){
        return Url::to(['/eiendommer', 'area' => $key]);
    }

    /**
     * Generate url from id for property
     * @param int|string $key
     * @return string Url
     */
    private function urlForPostNumber($key){
        return Url::to(["/annonse/{$key}"]);
    }
}
