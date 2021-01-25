<?php

namespace console\controllers;

use api\modules\mobile\modules\v1\models\PropertyDetails;
use api\modules\mobile\modules\v1\models\User;
use Kreait\Firebase\Database;
use Kreait\Firebase\Exception\ApiException;
use Yii;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;


class FirebaseController extends Controller
{

    /** @var Database $database */
    private $database;


    public function beforeAction($action)
    {
        $this->database = Yii::$app->firebase->database;
        return parent::beforeAction($action);
    }


    /**
     * @throws Exception
     * @throws ApiException
     */
    public function actionSynchronization()
    {
        $this->setUserFirebaseId();

        $this->importPropertyDetails();
        $this->exportForms();
    }

    private function setUserFirebaseId()
    {
        $users = User::find()
            ->select(User::$fields)
            ->where(["user.firebase_id" => null])
            ->active()->all();

        foreach ($users as $user) {
            $user->firebase_id = $this->database->getReference()->push()->getKey();
            $user->save(false);
        }
    }

    /**
     * import PropertyDetails to firebase
     *
     * @throws Exception
     * @throws ApiException
     */
    private function importPropertyDetails()
    {
        $reference = $this->database->getReference("eiendom");

        $users = User::find()
            ->select(["user.web_id", "user.firebase_id", "COUNT(property_details.id) as count"])
            ->joinWith(['propertyDetails' => function (ActiveQuery $query) {
                $query->select(PropertyDetails::fbFields())->with(["broker1", "broker2", "freeText", "image", "property"
                ])->andWhere([
                    "property_details.arkivert" => 0,
                    "property_details.vispaafinn" => -1,
                    "property_details.tinde_oppdragstype" => "Til salgs",
                ])
                    ->andWhere(["or",
                        ["property_details.solgt" => 0],
                        'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
                    ])
                    ->andWhere(["or",
                        ["=", "property_details.utlopsdato", 0],
                        [">", "property_details.utlopsdato", time()]
                    ]);
            }])->active()->groupBy(["user.web_id"])->asArray()->all();


        $i = 0;
        $count = array_sum(array_map(function ($item) {
            return $item["count"];
        }, $users));

        $fb_update = [];
        foreach ($users as $user) {

            $fb_user = $reference->getChild($user["firebase_id"]);

            foreach ($user["propertyDetails"] as $property) {
                $property["brokers"] = $property["broker1"] + $property["broker2"];
                unset($property["broker1"], $property["broker2"]);
                echo "import PropertyDetails : " . (++$i) . "/{$count}\r";
                if (!$property["firebase_id"]) {
                    $fb_property = $fb_user->push($property);
                    $property["firebase_id"] = $fb_property->getKey();
                    array_push($fb_update, ["id" => $property["id"], "firebase_id" => $property["firebase_id"]]);
                } else {
                    $fb_user->getChild($property["firebase_id"])->set($property);
                }
            }

        }

        if ($fb_update) {
            $db = Yii::$app->db;
            $sql = $db->queryBuilder->batchInsert("property_details", ["id", "firebase_id"], $fb_update);
            $db->createCommand("{$sql} ON DUPLICATE KEY UPDATE id = VALUES(id), firebase_id = VALUES(firebase_id)")->execute();
        }

        echo "\nSuccessfully!\n";
    }


    /**
     * export Forms to schala_db
     *
     * @throws ApiException
     * @throws Exception
     */
    private function exportForms()
    {
        $reference = $this->database->getReference("forms");
        $users = $reference->getValue();
        if (!$users) return;
        $fb_update = [];

        $form_keys = [
            "broker_id",
            "contact_me",
            "email",
            "firebase_id",
            "name",
            "phone",
            "send_sms",
            "subscribe_email",
            "target_id",
            "type",
            "created_at",
            "updated_at"
        ];

        sort($form_keys);

        foreach ($users as $user) {
            foreach ($user as $form) {
                if (!isset($form["id"]) && isset($form["firebase_id"])) {
                    unset($form["i_agree"]);
                    $form["type"] = "visningliste";
                    $form["updated_at"] = time();
                    array_push($fb_update, $form);
                }
            }
        }
        if ($fb_update) {
            $db = Yii::$app->db;
            $sql = $db->queryBuilder->batchInsert("forms", $form_keys, $fb_update);
            if ($db->createCommand($sql)->execute() > 0) {
                $column = ArrayHelper::getColumn($fb_update, "firebase_id");
                $this->importForms($column);
            }
        }
    }


    /**
     * import Forms to firebase
     *
     * @param $column
     * @throws ApiException
     * @throws Exception
     */
    private function importForms($column)
    {
        $reference = $this->database->getReference("forms");

        $form_keys = ["id", "type", "broker_id", "email", "name", "phone", "contact_me", "send_sms",
            "subscribe_email", "target_id", "firebase_id", "created_at", "updated_at"];

        $users = User::find()
            ->select(["user.web_id", "user.firebase_id", "COUNT(forms.id) as count"])
            ->joinWith(["forms" => function (ActiveQuery $query) use ($form_keys, $column) {
                $query->select($form_keys)->where(["in", "forms.firebase_id", $column]);
            }])->active()->groupBy(["user.web_id"])->asArray()->all();

        $i = 0;
        $count = array_sum(array_map(function ($item) {
            return $item["count"];
        }, $users));

        foreach ($users as $user) {
            $fb_user = $reference->getChild($user["firebase_id"]);
            foreach ($user["forms"] as $form) {
                echo "import Forms : " . (++$i) . "/{$count}\r";
                $fb_user->getChild($form["firebase_id"])->set($form);
            }
        }
        echo "\nSuccessfully!\n";
    }

}

