<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AllPostNumber;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * PropertyDetailsAdsSearch represents the model behind the search form of `common\models\PropertyDetails`.
 */
class PropertyDetailsAdsSearch extends PropertyDetails
{


    public $partner;
    public $office;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
//            [['post_number', 'city', 'municipal_number', 'municipal_name', 'category', 'neighbourhood'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var Partner $partner */
        $partner = Yii::$app->user->identity->partner;
        $employeesIds = ArrayHelper::getColumn(Partner::getAnsatteUsersData($partner->id), 'web_id');


        $query = PropertyDetails::find()->select([
            '`property_details`.*',
            'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group'
        ])
//            ->joinWith(['partner'])
            ->andWhere([
            'property_details.arkivert' => 0,
            'property_details.vispaafinn' => -1
        ])->andWhere(['or',
            ['property_details.solgt' => 0],
            'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
        ])->andWhere(['or',
            ['property_details.ansatte1_id' => $employeesIds],
            ['property_details.ansatte2_id' => $employeesIds]
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);


//        $query->andFilterWhere(['like', 'partner.id', $partner->id]);

        return $dataProvider;
    }
}
