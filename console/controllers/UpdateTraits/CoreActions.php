<?php
namespace console\controllers\UpdateTraits;


use Yii;
use common\models\ArchiveForm;
use common\models\Department;
use common\models\PercentText;
use common\models\PropertyVisits;
use Exception;
use common\models\PropertyDetails;
use common\models\PropertyNeighbourhood;
use common\models\Image;
use common\models\PropertyLinks;
use yii\console\ExitCode;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

trait CoreActions{
    use ConsoleActions;
    use GetFromApiTraits;
    use UpdatePropertyDetailsTrait;
    use UpdateAccountingTrait;
    use UpdateFreeTextTrait;
    use UpdateCriteria;
    use UpdateDocsTrait;
    use UpdateImagesTrait;
    /**
     * Contain ids of properties which changed their solgt attr from 0 -> -1
     * @var array
     */
    private static $googleGeocodeUrl = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDyziDv02leqwiVKBD9oEH4p1vwh0EoqOU&address=%s';
    private $fileDownloadDir = "webmegler-data";

    /**
     * Console Params
     */
    public $defaultTimeRange = 5;
    public $timeRange = '';
    public $fileNumber = 0;
    public $isShort = true;
    public $fileName;
    public $directoryName = 'items';
    public $updateActions = '';
    public $partnerId = null;
    public $firmaId = null;
    public $key = null;
    public $id = null;
    public $forceUpdate = false;
    public $isLightRequest = false;
    public $actionOffset = 0;
    private static $changedProperties = [];

    public function options($actionID){
        return ['id', 'actionOffset', 'key','partnerId','firmaId','timeRange', 'fileNumber', 'fileName', 'directoryName', 'updateActions', 'isShort', 'companyWebId', 'forceUpdate', 'isLightRequest'];
    }

    public function optionAliases(){
        return [
            'id' => 'id',
            'offset' => 'actionOffset',
            't' => 'timeRange',
            'f' => 'fileNumber',
            'd' => 'directoryName',
            'fn'=> 'fileName',
            'a' => 'updateActions',
            'is' => 'isShort',
            'cwid' => 'companyWebId',
            'force' => 'forceUpdate',
            'pid' => 'partnerId',
            'fid' => 'firmaId',
            'k' => 'key',
            'lite' => 'isLightRequest',
        ];
    }

    /**
     * decode actions passed from console
     * @return array
     */
    private function parseActions()
    {
        $a = $this->updateActions ? $this->updateActions :
            ($this->isLightRequest ? '100001000' : '')
        ;
        $updateActions = [
            'PropertyDetails',
            'PropertyFreeText',
            'PropertyImages',
            'Documents',
            'Neighbours',
            'Visits',
            'PropertyLinks',
            'PropertySpecialLeads',
            'Criterias',
        ];
        for ($j = 0; $j< strlen($a); $j++) {
            if ($a[$j] === '0') {
                unset($updateActions[$j]);
            }
        }

        return $updateActions;
    }

    public function beforeAction($action){
        $return = parent::beforeAction($action);
        if (!isset($this->oAuth2[$this->companyWebId])){
            echo "Invalid Company Id (cid) \n";
            $return = false;
        }
        return $return;
    }

    /**
     * @param string $className attachment class name
     * @param string $jsonPK primary key name in json
     * @param string|null $filterFunction filter function name for each row
     * @param string $foreignKey
     * @param array[] $jsonObjs
     * @param array[] $jsonProp
     * @param PropertyDetails $newPropD
     * @param int $pCount
     * @param bool $isShort
     * @throws \yii\db\Exception
     */
    private static function updatePropertyAttachment($className, $jsonPK, $filterFunction, $foreignKey, $jsonObjs, $jsonProp, $newPropD, $pCount = 0, $isShort = false)
    {
        /** @var ActiveRecord $className */
        $count = 0;
        $objs = $className::find()
            ->where(['and',
                [$foreignKey => $jsonProp['id'],],
                ['not', [$jsonPK => null]],
            ])
            ->indexBy($jsonPK)
            ->all()
        ;


        /** @var ActiveRecord $demoObj */
        $demoObj = new $className();
        $columnsNames = $demoObj->attributes();
        unset($columnsNames[array_search($demoObj->tableSchema->primaryKey[0], $columnsNames)]);

        $insertRows = [];
        foreach ($jsonObjs as $jsonObj) {
            // Echo comment con console or not
            if (!$isShort) {$count++;echo "Property {$className} -> {$jsonProp['id']} : N: {$pCount}:{$count} \n";}

            $insertRow = [];
            $jsonObj[$foreignKey] = $newPropD->id;// Link with Property
            $jsonObj = $filterFunction ? self::$filterFunction($jsonObj,$jsonObj) : $jsonObj;

            // Update attributes
            $unupdatedFieldsCount = 0;
            foreach ($columnsNames as $columnsName) {
                if (
                    isset($objs[ $jsonObj[$jsonPK] ])
                    && (
                        !isset($jsonObj[$columnsName])
                        || $jsonObj[$columnsName] == $objs[ $jsonObj[$jsonPK] ][ $columnsName ]
                    )
                ){// object exist in db and attribute didnt changed
                    $unupdatedFieldsCount++;
                }
                $insertRow[$columnsName] = isset($jsonObj[$columnsName]) ? $jsonObj[$columnsName] : null;
            }
            unset($objs[$jsonObj[$jsonPK]]);// See: $className:deleteAll after loop

            // Pass row if 0 field updated
            if (count($columnsNames) == $unupdatedFieldsCount){continue;}

            $insertRow[$jsonPK] = $jsonObj[$jsonPK];
            if (in_array('databasenummer', $columnsNames)){
                $insertRow['databasenummer'] = $jsonProp['databasenummer'];
            }
            $insertRows[] = $insertRow;
        }

        $db = Yii::$app->db;
        $sql = $db->queryBuilder->batchInsert($className::tableName(), $columnsNames, $insertRows);

        // TODO: use Replace yii support when Yii add it
        $sql = str_replace("INSERT INTO ","REPLACE INTO ",$sql);// Use Replace instead of Insert
        $db->createCommand($sql)->execute();

        // Remove all $objs that missing in json
        $className::deleteAll([
            $foreignKey => $jsonProp['id'],
            $jsonPK => array_keys($objs),
        ]);

    }

    /**
     * Isert or update  all  visits for property
     * @param $jsonProp array    property which belongs douments
     * @param $newProp Property parent property
     * @param int $pCount
     * @param bool $isShort
     * @return bool|integer
     */
    public static function updateVisits($jsonProp, $newPropD = null, $pCount = 0, $isShort = false)
    {
        $keyName = 'visninger';
        if (!isset($jsonProp[$keyName])) {
            return false;
        }
        $visits = (
            isset($jsonProp[$keyName][0]) &&
            isset($jsonProp[$keyName][0]['visning']) &&
            count($jsonProp[$keyName][0]['visning'])
        ) ? $jsonProp[$keyName][0]['visning'] : []
        ;


        $vCount = 0;

        PropertyVisits::deleteAll(['and',
            ['property_web_id'=>$newPropD->id,],
            ['>', 'fra', time()],
        ]);
        foreach ($visits as $visitObj) {
            if (!isset($visitObj['fra']) || strlen($visitObj['fra']) < 11) {
                continue; //ignore visit if start time is missing or didnt set exact time for it
            }
            $vCount++;
            // NOTE: Setup Primary key
            $visitObj['visit_id'] = $visitObj['id'];
            $visitObj['property_web_id'] = $newPropD->id;
            unset($visitObj['id']);

            $newVisit = PropertyVisits::findOne([
                'visit_id'=>$visitObj['visit_id'],
                'property_web_id'=>$newPropD->id,
            ]);
            $visitStatus = 'update';
            if (!$newVisit){
                $newVisit = new PropertyVisits();
                $visitStatus = 'new';
            }

            if (!$isShort) {
                echo "Property Visit -> {$jsonProp['id']} : N: {$vCount} -> {$visitStatus}\n";
            }

            // NOTE: Collect data and add untracked columns
            foreach ($visitObj as $name => $column) {
                $replaceName = str_replace('-', '_', $name);
                if (
                    !$newVisit->hasProperty($replaceName)
                    || is_array($column)
                ) {
                    continue;
                }
                $newVisit->setAttribute($replaceName, $column);
            }

            $newVisit->fra = strtotime($newVisit->fra);
            $newVisit->til = strtotime($newVisit->til);

            $newVisit->property_web_id = $newPropD->id;
            $newVisit->save(false);
        }
        return $vCount;
    }

    /**
     * @param string|array $data
     * @param PropertyDetails $newPropD
     * @param int $pCount
     * @param bool $isShort
     * @return void
     */
    public static function updateNeighbours($data, $newPropD = null, $pCount = 0, $isShort = false)
    {
        $file = false;
        PropertyNeighbourhood::deleteAll(['property_web_id' => $newPropD->id]);
        if (!is_array($data)) {
            $file = $data;
        } elseif (
            isset($data['alledokumenter']) &&
            isset($data['alledokumenter'][0]) &&
            isset($data['alledokumenter'][0]['dokument'])
        ) {
            foreach ($data['alledokumenter'][0]['dokument'] as $doc) {
                if (
                    isset($doc['filtype']) &&
                    $doc['filtype'] === "xml" &&
                    isset($doc['type_dokumentkategorier']) &&
                    $doc['type_dokumentkategorier'] === "Nabolagsprofil"
                ) {
                    $file = $doc['urldokument'];
                    break;
                }
            }
        }
        if (!$file) {return;}

        $file = file_get_contents($file);
        if (!$file) {return;}

        $start = '<jsonData><![CDATA';
        $end   = ']></jsonData>';

        $start = strpos($file, $start) + strlen($start);
        $end   = strrpos($file, $end) - $start;
        $file  = substr($file, $start, $end);
        $file  = json_decode($file, true)[0];
        $nCount = 0;
        $file['poiGroups'] = isset($file['poiGroups']) ? $file['poiGroups'] : [];
        foreach ($file['poiGroups'] as $neighbourData) {
            foreach ($neighbourData['pois'] as $poi) {
                $neighbour = new PropertyNeighbourhood();
                $disType = $poi['distances']['selected'];
                $neighbour->distance = $poi['distances'][$disType];
                $neighbour->name = $poi['name'];
                $neighbour->type = $neighbourData['name'];
                $neighbour->property_web_id = $newPropD->id;

                if (!$isShort) {
                    echo "Property Neighbour -> {$pCount}: {$neighbour->name} : N: {$nCount}\n";
                }
                $nCount++;
                $neighbour->save(false);
            }
        }

        // TODO: move to separate function
        $file['demographics'] = isset($file['demographics']) ? $file['demographics'] : [];
        $file['demographics']['percent_text'] = isset($file['demographics']['percent_text']) ? $file['demographics']['percent_text'] : [];
        PercentText::deleteAll(['property_web_id' => $newPropD->id]);
        $numbers = [5, 10, 7, 8, 2];
        $percentTexts = ArrayHelper::index($file['demographics']['percent_text'], 'id');
        // Order prioritysed objects
        $tCount = 0;
        foreach ($numbers as $number) {
            if (isset($percentTexts[$number])) {
                $percentText = new PercentText();
                $percentText->number = $percentTexts[$number]['id'];
                $percentText->name   = $percentTexts[$number]['name'];
                $percentText->value  = $percentTexts[$number]['value'];
                $percentText->link('property', $newPropD);
                $percentText->save(false);
                unset($percentTexts[$number]);
                $tCount++;
                if (!$isShort) {
                    echo "Property Percent Text -> {$pCount}: {$percentText->name} : N: {$tCount}\n";
                }
            }
        }

        // Insert rest of objects
        foreach ($percentTexts as $jsonObj) {
            $tCount++;
            $percentText = new PercentText();
            $percentText->number = $jsonObj['id'];
            $percentText->name   = $jsonObj['name'];
            $percentText->value  = $jsonObj['value'];
            $percentText->link('property', $newPropD);
            $percentText->save(false);
            if (!$isShort) {
                echo "Property Percent Text -> {$pCount}: {$percentText->name} : N: {$tCount}\n";
            }
        }
    }

    /**
     * @param array $jsonProp
     * @param PropertyDetails $newPropD
     * @param int $pCount
     * @param bool $isShort
     */
    private static function updatePropertySpecialLeads($jsonProp, $newPropD, $pCount = 0, $isShort = false)
    {
        $lCount = 0;
        $typeMap = [
            "selgere"=>'selger',
            "kjopere"=>'kjoper',
        ];
        $leadsObjects = [];
        foreach ($typeMap as $type=>$t) {
            if (
                isset($jsonProp[$type])
                && isset($jsonProp[$type][0])
                && isset($jsonProp[$type][0]['hovedkontakter'])
                && isset($jsonProp[$type][0]['hovedkontakter'][0])
                && isset($jsonProp[$type][0]['hovedkontakter'][0]['kontakt'])
            ) {
                foreach ($jsonProp[$type][0]['hovedkontakter'][0]['kontakt'] as $item) {
                    $item['type'] = $t;
                    $leadsObjects[] = $item;
                }
            }
        }

        $paramMap = [
            "fornavn"=>'',
            "etternavn"=>'',
            "adresse"=>null,
            "postnummer"=>null,
            "mobiltelefon"=>null,
            "email"=>null,
            "personnummer"=>null,
            "type"=>null,
            "fodselsdato"=>null,
            "id"=>null,
        ];
        foreach ($leadsObjects as $leadObj) {
            $lCount++;
            //Init params that must be used or set default if no exist
            foreach ($paramMap as $key=>$v) {
                $paramMap[$key] = isset($leadObj[$key]) ? $leadObj[$key] : $v;
            }

            //NOTE: uncomment on optimisation stage
            $newLead = ArchiveForm::findOne([
                'target_id' => $jsonProp['id'],
                'source_id' => $paramMap['id'],
                'type' => [
                    "selger",
                    "kjoper",
                ],
            ]);
            $newLeadStatus = 'Update';
            if (!$newLead) {
                $newLead = new ArchiveForm();
                $newLeadStatus = 'new';
            }
            if (!$isShort) {
                echo "Property Lead -> {$jsonProp['id']} : N: {$pCount}:{$lCount} -> {$newLeadStatus}\n";
            }
            $newLead->name      = "{$paramMap['fornavn']} {$paramMap['etternavn']}";
            $newLead->type      = $paramMap['type'];
            $newLead->target_id = $newPropD->id;
            $newLead->broker_id = $newPropD->ansatte1_id;
            $newLead->department_id = $jsonProp['id_avdelinger'];
            $newLead->address   = $paramMap['adresse'];
            $newLead->post_number = $paramMap['postnummer'];
            $newLead->phone     = $paramMap['mobiltelefon'];
            $newLead->email     = $paramMap['email'];
            $newLead->dob       = $paramMap['fodselsdato'] ? $paramMap['fodselsdato']
                : implode(
                    '.',
                    str_split(
                        substr($paramMap['personnummer'], 0, 6),
                        2
                    )
                )
            ;
            $newLead->save();
        }
    }

    /**
     * @param array $jsonProp
     * @param $newProp
     * @param PropertyDetails $newPropD
     * @param int $pCount
     * @param bool $isShort
     */
    private static function old_updatePropertyImages($jsonProp, $newPropD, $pCount = 0, $isShort = false)
    {
        $iCount = 0;
        Image::deleteAll(['propertyDetailId' => $jsonProp['id']]);
        if (
            !isset($jsonProp['bilder']) ||
            !isset($jsonProp['bilder'][0]) ||
            !isset($jsonProp['bilder'][0]['bilde'])
        ) {
            return;
        }
        foreach ($jsonProp['bilder'][0]['bilde'] as $imageObj) {
            $iCount++;
            $newImage = Image::findOne($imageObj['id']);
            $newImageStatus = 'Update';
            if (!$newImage) {
                $newImage = new Image();
                $newImageStatus = 'new';
            }

            if (!$isShort) {
                echo "Property Image -> {$jsonProp['id']} : N: {$pCount}:{$iCount} -> :{$newImageStatus}\n";
            }

            foreach ($imageObj as $name => $column) {
                if (!$newImage->hasProperty($name)) {
                    continue;
                }
                $newImage->setAttribute($name, $column);
            }

            if (!$newImage->urlstorthumbnail) {
                $newImage->urlstorthumbnail = $imageObj['urlstandardbilde'];
            }

            $newImage->save(false);
            $newPropD->link('images', $newImage);
        }
    }

    /**
     * Isert or update  all      visits for property
     * @param $jsonProp array    property which belongs douments
     * @param int $pCount
     * @param bool $isShort
     * @return bool|integer
     */
    public static function updatePropertyLinks($jsonProp, $newPropD = null, $pCount = 0, $isShort = false)
    {
        $keyName = 'allelinker';
        $smallKeyName = 'lenke';
        PropertyLinks::deleteAll(['property_web_id' => $newPropD->id]);
        if (
            !isset($jsonProp[$keyName]) ||
            !isset($jsonProp[$keyName][0]) ||
            !isset($jsonProp[$keyName][0][$smallKeyName])
        ) {
            return false;
        }
        $vCount = 0;
        foreach ($jsonProp[$keyName][0][$smallKeyName] as $linkObj) {
            if (!PropertyLinks::isRightLink($linkObj)) {
                continue;
            }
            $vCount++;
            // NOTE: Setup Primary key
            $linkObj['link_id'] = $linkObj['id'];
            $linkObj['property_web_id'] = $newPropD->id;
            unset($linkObj['id']);
            $newLink = new PropertyLinks();
            $linkStatus = 'new';

            if (!$isShort) {
                echo "Property Link -> {$jsonProp['id']} : N: {$vCount} -> {$linkStatus}\n";
            }

            // NOTE: Collect data and add untracked columns
            foreach ($linkObj as $name => $column) {
                $replaceName = str_replace('-', '_', $name);
                if (
                    !$newLink->hasProperty($replaceName)
                    || is_array($column)
                ) {
                    continue;
                }
                $newLink->setAttribute($replaceName, $column);
            }

            $newLink->property_web_id = $newPropD->id;
            $newLink->save(false);
        }
        return $vCount;
    }

    //TODO: move to some helper
    /**
     * @param $date
     * @param $format
     * @param bool $dateFormat
     * @return false|string
     */
    public static function changeDateFormat($date, $format, $dateFormat = false)
    {
        return $date ? date($format, strtotime($date)) : $date;
    }

    /**
     *
     *
     * @throws \yii\console\Exception
     */
    public function actionPushMarketingLinks()
    {
        $query = (new Query)
            ->from('property_details')
            ->select(['id', 'oppdragsnummer', 'avdeling_id'])
            ->where(['vispaafinn' => -1]);

        $total = (clone $query)->count();
        $done = 0;

        $schalaDepartments = Department::find()
            ->select('web_id')
            ->where(['partner_id' => 1])
            ->column();

        Console::startProgress($done, $total);

        foreach ($query->each(50) as $property) {
            $isSchalaPartners = array_search($property['avdeling_id'], $schalaDepartments) !== false;

            $this->deliverMarketingLinks($property['id'], $property['oppdragsnummer'], $isSchalaPartners);

            Console::updateProgress(++ $done, $total);
        }

        Console::endProgress();

        return ExitCode::OK;
    }

    /**
     *
     *
     * @param $id
     * @param $oppdragsnummer
     * @param $isSchalaPartners
     *
     * @throws \yii\console\Exception
     */
    public function deliverMarketingLinks($id, $oppdragsnummer, $isSchalaPartners)
    {
        $this->companyWebId = $isSchalaPartners ? '343' : '233';

        $xml = '<?xml version="1.0" encoding="iso-8859-1"?>
            <!DOCTYPE leveranse SYSTEM "http://secure.webmegler.no/static/v4/dtd/leveranse/webmegler_leveranse_versjon2_1.dtd">
            <leveranse>
                <oppdrag>
                    <oppdragsnummer>'.$oppdragsnummer.'</oppdragsnummer>
                </oppdrag>
                <linker>
                    <link nettpublisert="false" lagresomdokument="false">
                        <url>https://partners.no/admin/embed/'.$id.'</url>
                        <linkvisningsnavn>Statistikk (boligportalen)</linkvisningsnavn>
                    </link>
                    <link nettpublisert="false" lagresomdokument="false">
                        <url>https://partners.no/admin/embed/'.$id.'?view=dashbord</url>
                        <linkvisningsnavn>Statistikkdashboard (boligportalen)</linkvisningsnavn>
                    </link>
                </linker>
                <varsling sendemailvarsel="false" />
            </leveranse>';

        $this->updateAuthToken();

        $ch = curl_init("https://api.webmegler.no/legacy/net/wneksternleveranse.ashx?id_konsern={$this->companyWebId}");

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'],
                'Content-type: application/xml',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5,
        ]);

        $response = curl_exec($ch);

        curl_close($ch);
    }
}

