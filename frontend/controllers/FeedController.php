<?php


namespace frontend\controllers;

use common\components\Befaring;
use common\components\CdnComponent;
use common\models\PropertyDetails;
use Firebase\JWT\JWT;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class FeedController extends Controller
{
    public function actionListings()
    {
        require '../config/OAuthPublicKey.php';

        try {
            $jwt = '';
            $headers = Yii::$app->request->headers;
            if ($headers->has('Authorization')) {
                $authorization = $headers->get('Authorization');
                $parts = explode(' ', $authorization);
                $jwt = $parts[1];
            }
            $decoded = JWT::decode($jwt, $publicKey, ['RS256']);

            if (!in_array('schala.feed.read', $decoded->scopes)) {
                throw new Exception();
            }
        } catch (\Throwable $th) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->statusCode = 401;
            $response->data = [
                'error' => 'Unauthorized',
                'status' => 401
            ];
            return $response;
        }

        /** @var PropertyDetails[] $properties */
        $properties = PropertyDetails::find()->alias('pd')->select([
            'pd.id',
            'pd.oppdragsnummer',
            'pd.solgt',
            'pd.overskrift',
            'pd.postnummer',
            'pd.antallrom',
            'pd.kommuneomraade',
            'pd.poststed',
            'pd.prisantydning',
            'pd.ansatte1_id',
            'pd.adresse',
            'pd.prom',
            'pd.tomteareal',
            'pd.bruksareal',
            'pd.prom',
            'pd.tomteareal',
            'pd.avdeling_id',
            'pd.type_eiendomstyper',
        ])->with([
            'images' => function (\yii\db\ActiveQuery $query) {
                $query->alias('i')->select([
                    'propertyDetailId',
                    'urloriginalbilde',
                    'urlstorthumbnail'
                ])->orderBy('CAST(i.nr AS UNSIGNED INTEGER)', 'ASC');
            },
            'propertyVisits' => function ($query) {
                $query->select([
                    'id',
                    'property_web_id',
                    'fra'
                ])->orderBy(['fra' => SORT_DESC]);
            },
            'user' => function ($query) {
                $query->select([
                    'web_id',
                    'email',
                    'urlstandardbilde',
                    'mobiltelefon',
                    'navn'
                ]);
            },
            'freeTextTitle',
        ])->innerJoinWith([
            'partner' => function ($query) {
                $query->alias('p')->select('*');
                if ($slug = Yii::$app->request->get('partner')) {
                    $query->where(['p.slug' => $slug]);
                }
            },
            'department' => function ($query) {
                $query->alias('d')->select('*');
                if ($url = Yii::$app->request->get('department')) {
                    $query->where(['d.url' => $url]);
                }
            }
        ])
            ->where(['or',
                ['<>', 'pd.tinde_oppdragstype', 'Prosjekt'],
                ['pd.involve_adv' => true]
            ])
            ->andWhere(['vispaafinn' => -1])->all();

        $listings = [];

        foreach ($properties as $property) {
            $title = $property->getTitle() . ', ' . $property->adresse;
            $brokerAvatar = $property->user->urlstandardbilde ?? null;

            $listing = [
                'id' => (string)$property->oppdragsnummer,
                'adName' => $title,
                'adTitle' => $title,
                'adDescription' => 'Ingen visninger i systemet',
                'adMessage' => $property->overskrift,
                'adUrl' => 'https://partners.no/eiendommer/' . $property->oppdragsnummer,
                'campaignName' => $title,
                'address' => $property->adresse,
                'postalCode' => sprintf('%04d', $property->postnummer),
                'area' => (int)$property->propertyArea(false),
                'brokerEmail' => $property->user->email ?? null,
                'brokerImage' => $brokerAvatar,
                'brokerPhone' => $property->user->mobiltelefon ?? null,
                'brokerName' => $property->user->navn ?? null,
                'currency' => 'NOK',
                'price' => (int)$property->prisantydning,
                'rooms' => (int)$property->antallrom,
                'sold' => $property->solgt === -1,
                'images' => [],
            ];

            $i = 0;

            foreach ($property->images as $image) {
                // Get 7 images, skip number 2
                if ($i < 16 && $i !== 1) {
                    $listing['images'][] = CdnComponent::optimizedUrl(
                        !empty($image->urlstorthumbnail) ? $image->urlstorthumbnail : $image->urloriginalbilde,
                        1920
                    );
                }

                $i++;
            }

            if ($property->propertyVisits) {
                $listing['adDescription'] = 'Visning: ' . date('d.m \k\l. H:i', $property->propertyVisits[0]->fra);
            }

            $listings[] = $listing;
        }

        if (strToLower(Yii::$app->request->get('format')) == 'xml') {
            return $this->asXml($listings);
        }

        return $this->asJson($listings);
    }

}
