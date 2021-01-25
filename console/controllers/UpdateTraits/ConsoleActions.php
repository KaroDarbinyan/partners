<?php
namespace console\controllers\UpdateTraits;


use common\models\Accounting;
use common\models\Department;
use common\models\Process;
use console\models\Forms;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\User;
use console\components\MultyConnection;
use console\controllers\WebmeglerController;
use Yii;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\Json;

trait ConsoleActions{
    private static $currentlySolgtMessages = [];
    private static $currentlySolgtIds = [];

    private $reauestArgs = [
        'default' => [
            '233' =>[
                'visallefritekster' => "-1",
                'visalleendringer' => "-1",
                'visarkiverteoppdrag' => "-1",
                'visomsetningsdata' => "-1",
                'visbefaringsoppdrag' => "-1",
            ],

            '343' =>[
                'visallefritekster' => "-1",
                'visalleendringer' => "-1",
                'visarkiverteoppdrag' => "-1",
                'visomsetningsdata' => "-1",
                'visbefaringsoppdrag' => "-1",
            ],
        ],

        'light' => [
            '233' =>[
                'skjulsalgsoppgavetekster'=> "-1",
                'skjuloppdragsbilder'=> "-1",
                'skjuloppdragsdokumenter'=> "-1",
            ],

            '343' =>[
                'skjulsalgsoppgavetekster'=> "-1",
                'skjuloppdragsbilder'=> "-1",
                'skjuloppdragsdokumenter'=> "-1",
            ],
        ],
    ];


    /**
     * @param $fileName
     * @return bool
     */
    private function mayUpdateProperties($fileName){
        if (file_exists($fileName)){
            $lastUpdateTime = intval(file_get_contents($fileName));
        }else{
            $lastUpdateTime=time() - $this->timeRange * 60;
        }
        return !$this->forceUpdate
            && !$lastUpdateTime
            && (time() - filemtime($fileName))/60 < 30
        ;
    }

    /**
     * Update Properties : if timeRange is -1 then requet all data, but work only at night
     * @param array|false $props assoc array of properties
     * @param bool $isShort ignore echo for components, just echo number of properties (NOT IMPLEMENTED)
     * @param array|false $updateActions
     * @return int exit code
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @command yii webmegler/update-properties
     */
    public function actionUpdateProperties($props = false, $isShort = false, $updateActions = false, $silnce = false){
        $ds = DIRECTORY_SEPARATOR;
        //TODO:: pass requestTime from large function

        // Uncomment fo test actions
        // $this->updateActions = '110100000';
        if (is_array($props) && !count($props)){
            if(!$silnce){
                echo "No Properties pass to action\n";
            }
            return;
        }
        /** @var MultyConnection $db */
        $ds = DIRECTORY_SEPARATOR;
        $processOld = Process::find()
            ->where([
                'type'=>$this->isLightRequest ? ['property','propertyL'] : 'property',
                'db_id'=>$this->companyWebId,
            ])->orderBy(['requestdate'=> SORT_DESC])
        ;
        $processOld = $processOld->one();
        /** @var Process $processOld */
        
        if (!$this->forceUpdate && $processOld && $processOld->isParalelProcess()){// There is a process that still runing
            if(!$silnce){
                echo 'another update in progress try later';
            }
            return ExitCode::OK;
        }

        if ($processOld){
            $lastUpdateTime = $processOld->requestdate;
        }else{
            $lastUpdateTime = time() - $this->defaultTimeRange * 60;
        }

        // Use difference between last update minuus extra minute and now as time range for next update
        // Or manul time range (or default) if request is forced or time range set manually
        $timeRange = (!$this->forceUpdate && !$this->timeRange)
            ? ceil(1 + ( time() - $lastUpdateTime )/60)
            : ($this->timeRange ? $this->timeRange : $this->defaultTimeRange);
        $process = false;
        if (!isset(Yii::$app->request->isAjax)){
            $process = new Process();
            $process->pid = getmypid();
            $process->type = 'property' . ($this->isLightRequest ? 'L' : '');
            $process->db_id = $this->companyWebId;
        }

        $updateActions = $updateActions ? $updateActions : $this->parseActions();
        $logText = date("F j, Y, g:i a") . " start Property \n";
        file_put_contents(
            __DIR__ . $ds . ".." .  $ds . "logs" . $ds . "log.log",
            $logText,
            FILE_APPEND
        );


        $isShort = $isShort ? $isShort : $this->isShort;
        // TODO: Fix log functional
        $log = [
            'update' => 0,
            'new' => 0,
        ];
        if ($process){
            $process->requestdate = time() - $timeRange * 60;
            $requestTime = time();
            if ($processOld && $processOld->type == $process->type){//Remove old process if it has same type as current, to avoid data loss
                $processOld->delete();
            }
            $process->save();//Save process and lock for other process to run see file ConsoleAtions.php:81
        }

        // Uncomment to read from file for testing
        // $props = json_decode( file_get_contents('requests-results/update_data_for_test.json'), true );

        if (!$props) {// Get props from api if not pass to function
            $ra = $this->getRequestParamsString();
            $props = $this->get(
                'properties',
                [
                    $timeRange,
                    $ra,//"&vistommeelementer=-1&visalleendringer=-1&visarkiverteoppdrag=-1&visomsetningsdata=-1&visbefaringsoppdrag=-1&visbefaringsoppdrag=-1"
                ],
                true,
                Yii::getAlias('@yiiroot') . $ds . "requests-results{$ds}update_data_for_m_{$timeRange}"
            );
        }

        if (!isset($props['eneiendom'])){
            if(!$silnce){
                echo "NO Properties to update \n";
            }
            if($process){
                $logMessage = date("F j, Y, g:i a") . "  NO Properties to update \n";
                file_put_contents(Yii::getAlias('@yiiroot') . $ds  . 'webmegler_update_log.log', $logMessage, FILE_APPEND);
                $process->delete();// Remove process to unlock others
            }
            return ExitCode::OK;
        }
        $props = $props['eneiendom'];

        $defaultActions = [];
        foreach ($updateActions as $updateAction) {
            $defaultActions[$updateAction] = "";
        }

        $pCount = 0;
        $skiped = 0;
        $depPartnerMap = (new \yii\db\Query())
            ->select(['department.web_id', 'partner.slug'])
            ->from(Department::tableName())
            ->leftJoin(Partner::tableName(), Department::tableName() . '.partner_id = ' . Partner::tableName() . '.id')
            ->indexBy('web_id')
            ->all()
        ;

        foreach ($props as $jsonProp) {
            // TODO: remove folloing hotfix after webmegler db stabilisation ( compleatly remove 3000006 department )
            $brokerMap = [
                "3001685"=>	"3001732",
                "3001611"=>	"3001730",
                "3001612"=>	"3001729",
            ];
            if (isset($jsonProp['ansatte1_id']) && isset($brokerMap[$jsonProp['ansatte1_id']]) ){
                $jsonProp['ansatte1_id'] = $brokerMap[$jsonProp['ansatte1_id']];
            }

            if (isset($jsonProp['avdeling_id']) && '3000109' == $jsonProp['avdeling_id'] ){
                $jsonProp['avdeling_id'] = '3000116';
            }
            // hotfix end
            try{
                $actions = $defaultActions;
                // TODO: create some union function for update parts
                $pCount++;
                if ($isShort && !$silnce) {
                    echo "Property {$isShort} {$pCount}\n";
                }

                if (!isset($actions['PropertyDetails'])){
                    if (!$silnce){
                        echo "PropertyDetails action must be called \n";
                    }
                    return false;
                }
                $partner = isset($depPartnerMap[$jsonProp['avdeling_id']]) ? $depPartnerMap[$jsonProp['avdeling_id']]['slug'] : false;

                if (!$partner){
                    if (!$silnce){
                        echo "skip Property from {$jsonProp['avdeling_id']} dep\n";
                    }
                    $skiped++;
                    continue;
                }

                /**
                 * Insert Data in property_details
                 */
                unset($actions['PropertyDetails']);
                $newPropD = self::getPropertyDetailsModel($jsonProp, $pCount, $isShort);
                /** @var PropertyDetails $newPropD */
                if (!PropertyDetails::findOne(['id'=>$newPropD->id])){
                    $newPropD->setOldAttributes(null);
                }

                $newPropD->save(false);// TODO: fix validation and remove false

                foreach ($actions as $action => $_q) {
                    $action = "update{$action}";
                    // ATTANTION: call to update function
                    self::{$action}($jsonProp, $newPropD, $pCount, $isShort);
                }
                self::handleOutdatedDepartments();
                self::handleOutdatedBrokers();

                if (false) {// NOTE: The following functions called from previous loop
                    self::updatePropertyFreeText($jsonProp, $newPropD, $pCount, $isShort);
                    self::updatePropertyImages($jsonProp, $newPropD, $pCount, $isShort);
                    self::updateDocuments($jsonProp, $newPropD, $pCount, $isShort);
                    self::updateNeighbours($jsonProp, $newPropD, $pCount, $isShort);
                    self::updateVisits($jsonProp, $newPropD, $pCount, $isShort);
                    self::updatePropertyLinks($jsonProp, $newPropD, $pCount, $isShort);
                    self::updatePropertySpecialLeads($jsonProp, $newPropD, $pCount, $isShort);
                    self::updateCriterias($jsonProp, $newPropD, $pCount, $isShort);
                }
            }catch(Exception $e){
               file_put_contents('php-error-custom.log', date("F j, Y, g:i a") . " :: " . $e->getMessage(), FILE_APPEND);
               echo $e->getMessage();
            }
        }

        /** push socket data  start */
        if (self::$currentlySolgtMessages) {
            $path = \Yii::getAlias('@console').'/runtime/propertyDetails';
            if (!is_dir($path)) {
                mkdir($path);
            }
            file_put_contents($path.'/data.json', print_r(json_encode(self::$currentlySolgtMessages), true));
        }
        /** push socket data  end */
        // Logging // TODO: create function for logging
        $logMessage = date("F j, Y, g:i a") . "  Update: {$log['update']}  New: {$log['new']} \n";
        file_put_contents(Yii::getAlias('@yiiroot') . $ds  . 'webmegler_update_log.log', $logMessage, FILE_APPEND);
        if (!$silnce){
            echo $logMessage;
            echo "Total Properties: {$pCount} Skiped: {$skiped}\n";
        }
        $logText = date("F j, Y, g:i a") . " END\n";
        file_put_contents(
            __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "log.log",
            $logText,
            FILE_APPEND
        );

        $this->handleChangedProperties();

        Forms::initiateSalgSums(self::$currentlySolgtIds);
        if ($process){
            $process->requestdate = $requestTime;
            $process->save();
        }
        return ExitCode::OK;
    }

    /**
     * Update Properties : from files
     * @command yii webmegler/update-from-files -d=directory name -force
     * @param string $action action name to update the data
     * @throws \Throwable
     */
    public function actionUpdateFromFiles($action = "actionUpdateProperties"){
        $i = $this->fileNumber;//-f
        $d = $this->directoryName;//-d

        $this->forceUpdate = true;
        $fStart = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . "requests-results" ;
        while (file_exists("{$fStart}/{$d}/item{$i}.json")) {
            $fileName = "{$fStart}/{$d}/item{$i}.json";
            $items = json_decode(file_get_contents($fileName), true);

            $updateActions = $this->parseActions();
            $this->$action($items, $i, $updateActions);
            if(false){//TODO: remove after production : this part is just for phpShtorm link
                $this->actionUpdateProperties($items, $i, $updateActions);
                $this->actionUpdateAccounting($items, $i, $updateActions);
            }
            $i++;
            file_put_contents(Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . 'large_file_parts.log', date('d-m-Y') . " {$fileName} \n", FILE_APPEND) ;
        }
    }

    /**
     * Set department_id to 0 ( Default ) for leads where department is missing in departments table
     * @throws \yii\db\Exception
     */
    public function handleOutdatedDepartments()
    {
        // $formTable = Forms::tableName();
        // $depTable = Department::tableName();
        // Yii::$app->db->createCommand("
        //   UPDATE {$formTable} LEFT JOIN {$depTable}
        //   ON {$formTable}.department_id = {$depTable}.web_id
        //   SET {$formTable}.department_id=1
        //   WHERE {$depTable}.web_id IS NULL && {$formTable}.department_id IS NOT NULL
        // ")->execute();
    }

    /**
     * Set broker_id to 0 ( Default ) for leads where broker is missing in user table
     * @throws \yii\db\Exception
     */
    public function handleOutdatedBrokers()
    {
        $formTable = Forms::tableName();
        $userTable = User::tableName();
        Yii::$app->db->createCommand("
          UPDATE {$formTable} LEFT JOIN {$userTable}
          ON {$formTable}.broker_id = {$userTable}.web_id
          SET {$formTable}.broker_id= " . User::TEST_BROKER_ID . "
          WHERE {$userTable}.web_id IS NULL && {$formTable}.broker_id IS NOT NULL
        ")->execute();
    }

    /**
     * @param bool $range
     * Command: php yii webmegler/large -t=5 -cwid=343 -force
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLarge($range = false)
    {
        // Data request range until now in minutes
            $range = $range ? $range : ($this->timeRange ? $this->timeRange : $this->defaultTimeRange);
        $dateFormat = 'Y.m.d.H.i';
        $start = date($dateFormat, strtotime("-{$range}minutes", time()));
        $end = $range ? date($dateFormat, time()) : '';
        $file =  "result{$start}-{$end}.xml";
        $storeFileDir = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . $this->fileDownloadDir . DIRECTORY_SEPARATOR . "properties" . DIRECTORY_SEPARATOR;
        $storeFile = $storeFileDir . $file;

        if (!file_exists($storeFileDir)) {
            mkdir($storeFileDir, 0777, true);
        }

        $this->updateAuthToken();

        $range = $range ? "/m{$range}" : '';
        $args = [
            "url" => $this->requests['properties']['url'],
        ];
        $ra = $this->getRequestParamsString();
        $args['url'] = str_replace(
            '{{companyWebId}}',
            $this->companyWebId,
            $args['url']
        );
        $args['url'] = str_replace(
            '{{params}}',
            $ra,//additional Params
            $args['url']
        );
        $args['url'] = str_replace('/m{{minutes}}', $range, $args['url']);

        if (isset($args['args']) && is_array($args['args'])) {
            $args['args'] = http_build_query($args['args']);
        }

        $args['file'] = fopen($storeFile, file_exists($storeFile) ? 'w' : 'w+');
        $args['timeout'] = 0;
        $args['isFile'] = true;
        if(!$this->oAuth2[$this->companyWebId]){
            echo "Invalid Company Id (cid) \n";
        }
        $params = array(
            'url'       => array( CURLOPT_URL ),
            'isPost'    => array( CURLOPT_POST ),
            'file'      => array( CURLOPT_FILE ),
            'timeout'   => array( CURLOPT_TIMEOUT ),
            'isFile'    => array( CURLOPT_FOLLOWLOCATION ),
            'args'      => array( CURLOPT_POSTFIELDS ),
            'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
            'headers'   => array(
                CURLOPT_HTTPHEADER,
                array('Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'])
            ),
        );

        $ch = curl_init();
        foreach ($params as $key => $param) {
            if (isset($args[$key])) {
                $param[1] = $args[$key];
            }
            if (isset($param[1])) {
                curl_setopt($ch, $param[0], $param[1]);
            }
        }

        set_time_limit(0);
        //This is the file where we save the    information
        file_put_contents($storeFile, '');
        $fp = fopen($storeFile, file_exists($storeFile) ? 'w' : 'w+');
        //Here is the file we are downloading, replace spaces with %20
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // get curl response
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        // uncomment following file for demo content
        //$file =  "result2020.01.16.00.30-.xml";
        $this->directoryName = $this->actionSplitFile($file);
        $this->actionUpdateFromFiles();
    }

    /**
     * @param bool $file
     * @param array|bool $params
     * @param array|function $extraXmlFormaterFunction function for additional formating xml
     * @return string
     */
    public function actionSplitFile($file = false, $params = [
            'subDir' => 'properties',
            'itemsInFile' => 50,
            'itemStart' => '<eneiendom>',
            'itemEnd' => '</eneiendom>',
            'contentEnd' => '</eiendommer>',
        ],
        $extraXmlFormaterFunction = array('console\controllers\WebmeglerController', 'xmlObjToAssocArray')

    ){
        $file = $file ? $file : $this->fileName; // -fn
        $d = str_replace(".xml", "", $file);
        $d = "items" . preg_replace('/[a-z,A-z,:]/', '', $d);
        $d = $params['subDir'] . DIRECTORY_SEPARATOR . $d;
        $dir = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . "requests-results" . DIRECTORY_SEPARATOR . $d . DIRECTORY_SEPARATOR;
        $file = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . $this->fileDownloadDir . DIRECTORY_SEPARATOR . $params['subDir'] . DIRECTORY_SEPARATOR .  $file;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $contentStart = '';
        $start = '';
        $item = '';
        $items = '';
        $line = '';
        $j = -1;
        $itemStartLenght = strlen($params['itemStart']);
        $itemEndtLenght = strlen($params['itemEnd']);

        $file = fopen($file, "r");
        $itemsCount = 0;
        /**
         * Move file pointer after xml start section
         */
        while (!feof($file) && strpos($line, $params['itemStart']) === false) {
            $line = fgets($file);
            $contentStart.= $line ;
        }
        $line = substr($line, strpos($line, $params['itemStart']));
        $contentStart = substr($contentStart, 0, strpos($contentStart, $params['itemStart']));

        while (!feof($file)) {
            $j++;
            $items = '';
            for ($i = 0; $i < $params['itemsInFile']; $i++) {
                while (//Find property Start
                    !feof($file)
                    && strpos($line, $params['itemStart']) === false
                ) {$line = fgets($file);}

                if ($line === false) {
                    break;
                }
                // Cut cut useless parts before $itemStart
                $item = substr($line, strpos($line, $params['itemStart']));

                while (// Concant untill property end
                    false !== ($line = fgets($file))
                    && strpos($line, $params['itemEnd']) === false
                ) {$item .= $line;}

                $endPos = strpos($line, $params['contentEnd']) + $itemEndtLenght + 1;
                $item .= substr($line, 0, $endPos);
                $itemsCount++;
                $items .= $item;
                if ($line === false) {break;}// Break on file end  
            }//End For
            $items = "{$contentStart}{$items}{$params['contentEnd']}";

            $items = simplexml_load_string($items);
            if($extraXmlFormaterFunction){
                $items = forward_static_call_array($extraXmlFormaterFunction, [$items]);
            }
            // $items = WebmeglerController::xmlObjToAssocArray($items);
            $itemFileName = "{$dir}item{$j}.json";
            file_put_contents($itemFileName, json_encode($items));
        }
        fclose($file);
        if (!$itemsCount) {
            echo "\n no items detected \n";
        }
        return $d;
    }

    /**
     * @throws Exception
     */
    public function actionGet()
    {
        $key = $this->key;
        $entity = 'property';
        $args = [$key];
        $this->updateAuthToken();
        $action = 'get' . ucfirst($entity);
        $data = $this->$action($args);
        $file = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . "custom_gets/{$entity}-{$args[0]}.json";
        file_put_contents($file, json_encode($data));
        $this->actionUpdateProperties($data,false);
    }

    /**
     * Logging changed properties
     */
    public function handleChangedProperties()
    {
        if (
            empty(self::$changedProperties)
            || isset(Yii::$app->params['slackReport']) && !Yii::$app->params['slackReport']
        ) {// there is no changes or slack reports is turned off
            return;
        }
        $message = '';
        foreach (self::$changedProperties as $key => $property) {
            $message .= "https://partners.no/annonse/{$key} ble endret:\n";
            foreach ($property as $column => $values) {
                if ($column === 'markedsforingsdato') {
                    foreach ($values as $key => $value) {
                        if ($value > 0) {
                            $values[$key] = date('d.m.y H:i', $value);
                        }
                    }
                }
                $message .= "{$column} fra {$values['old']} til {$values['new']}\n";
            }
        }

        $ch = curl_init('https://hooks.slack.com/services/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');
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['text' => $message,]),
            CURLOPT_HTTPHEADER => ['Content-type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @throws Exception
     * @throws \Throwable
     * command php yii webmegler/update-properties-by-ids -force -f=integer  number of last updated property
     */
    public function actionUpdatePropertiesByIds(){
        $ids = $fields = array();
        $props = [];
        $handle = @fopen('data' . DIRECTORY_SEPARATOR . 'partners_oppdrag_siden_20150101.txt', "r");
        if (!$handle) {return;}
        $i = -1;
        while (($row = fgetcsv($handle, 4096)) !== false) {
            if (empty($fields)) {
                $fields = $row;
                continue;
            }
            $i++;
            if ($i < $this->fileNumber){//-f
                continue;
            }
            foreach ($row as $k=>$value) {
                $ids[$i][$fields[$k]] = $value;
            }
            if ($ids[$i]['oppdragsnummer'] == 0){//-f
                continue;
            }
            echo "Requesting {$i}(th) prop web_id => {$ids[$i]['oppdragid']}\n";
            $p = $this->get('property',["i{$ids[$i]['oppdragid']}"]);
            if(!count($p)){
                echo "invalid {$ids[$i]['oppdragid']}\n";
                echo "sleep(10)\n";
                sleep(10);
                $p = $this->get('property',["i{$ids[$i]['oppdragid']}"]);
                if(!count($p)){
                    echo "Truly invalid {$ids[$i]['oppdragid']}\n";
                    file_put_contents('property_with_invalid_xmls.txt', "oppdragid = {$ids[$i]['oppdragid']}\n",FILE_APPEND);
                    continue;
                }

            }
            $props[] = $p['eneiendom'][0];
            if(count($props) >= 50){
                $this->actionUpdateProperties(['eneiendom'=>$props], true);
                $props = [];
            }
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
    }

    /**
     * @throws Exception
     * @throws \Throwable
     * command php yii webmegler/update-properties-by-partner -force -pid=partnerId
     */
    public function actionUpdatePropertiesByPartner(){
        $pId = $this->partnerId;
        if (!$pId){
            echo "set -pid=<partner id>\n";
            return;
        }

        $brokerIds = User::find()
            ->select([
                'user.web_id',
                'user.id_avdelinger',
            ])->joinWith(['department'], false)
            ->where(['department.partner_id' => $pId])
            ->asArray()
            ->indexBy('web_id')
            ->all()
        ;

        foreach ($brokerIds as $brokerId => $broker) {
            $b = $this->get('employee_properties',[$brokerId]);
            if (!count($b)) {continue;}

            foreach ($b['eneiendom'] as $prop) {
                echo "Requesting Property webId = {$prop['id']}\n";
                $p = $this->get('property',["i{$prop['id']}"]);
                if(!count($p)){
                    echo "invalid {$prop['id']}\n";
                    echo "sleep(10)\n";
                    sleep(10);
                    $p = $this->get('property',["i{$prop['id']}"]);
                    if(!count($p)){
                        echo "Truly invalid {$prop['id']}\n";
                        file_put_contents('property_with_invalid_xmls.txt', "oppdragid = {$prop['id']}\n",FILE_APPEND);
                        continue;
                    }
                }
                $this->actionUpdateProperties($p, true);
            }

        }
        return;
    }

    /**
     * @param bool $range
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @command php yii webmegler/large-accounting -t=01.01.2019-01.05.2020 -cwid=343
     */
    public function actionLargeAccounting($range = false){
        if(!$this->oAuth2[$this->companyWebId]){
            echo "Invalid Company Id (cwid) \n";
        }
        $firmaIds = $this->firmaId ? [['id_firma' => $this->firmaId]] : Department::find()
            ->joinWith(['partner'], false)
            ->where(['partner.wapi_id'=> $this->companyWebId])
            ->select(['id_firma'])
            ->groupBy(['id_firma'])
            ->asArray()->all()
        ;
        // Data request range until now in minutes
        $range = $range ? $range : ($this->timeRange ? $this->timeRange
            : date('d.m.yy', time() - 2*24*60*60) . '-' . date('d.m.yy')
        );// -t
        if (!$range){
            echo "Time range is missing (-t=dd.mm.yyyy-dd.mm.yyyy)\n";
            return;
        }
        $ranges = explode('-',$range);

        $storeFileDir = Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . $this->fileDownloadDir . DIRECTORY_SEPARATOR . "accounting" . DIRECTORY_SEPARATOR;
        if (!file_exists($storeFileDir)) {
            mkdir($storeFileDir, 0777, true);
        }

        // Loop over all department.id_firma-s of choosen database-id
        foreach ($firmaIds as $d) {
            $file =  "result{$range}-{$d['id_firma']}.xml";
            $storeFile = $storeFileDir . $file;

            $this->updateAuthToken();

            $args = [
                "url" => $this->requests['accounting']['url'],
            ];
            //TODO: use getProperties function instead of followoing
            $args['url'] = str_replace(
                '{{companyWebId}}',
                $this->companyWebId,
                $args['url']
            );
            // Set Start date in request url
            $args['url'] = str_replace(
                '{{start}}',
                $ranges[0],
                $args['url']
            );

            // Set End date in request url
            $args['url'] = str_replace(
                '{{end}}',
                $ranges[1],
                $args['url']
            );

            // Set Firma id in request url
            $args['url'] = str_replace(
                '{{id_firma}}',
                $d['id_firma'],
                $args['url']
            );

            if (isset($args['args']) && is_array($args['args'])) {
                $args['args'] = http_build_query($args['args']);
            }

            $args['file'] = fopen($storeFile, file_exists($storeFile) ? 'w' : 'w+');
            $args['timeout'] = 0;
            $args['isFile'] = true;

            $params = array(
                'url'       => array( CURLOPT_URL ),
                'isPost'    => array( CURLOPT_POST ),
                'file'      => array( CURLOPT_FILE ),
                'timeout'   => array( CURLOPT_TIMEOUT ),
                'isFile'    => array( CURLOPT_FOLLOWLOCATION ),
                'args'      => array( CURLOPT_POSTFIELDS ),
                'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
                'headers'   => array(
                    CURLOPT_HTTPHEADER,
                    array('Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'])
                ),
            );

            $ch = curl_init();
            foreach ($params as $key => $param) {
                if (isset($args[$key])) {
                    $param[1] = $args[$key];
                }
                if (isset($param[1])) {
                    curl_setopt($ch, $param[0], $param[1]);
                }
            }
            set_time_limit(0);
            //This is the file where we save the    information
            file_put_contents($storeFile, '');
            $fp = fopen($storeFile, file_exists($storeFile) ? 'w' : 'w+');
            //Here is the file we are downloading, replace spaces with %20
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            // write curl response to file
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // get curl response
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            $this->directoryName = $this->actionSplitFile($file, [
                'subDir' => "accounting",
                'itemsInFile' => 50,
                'itemStart' => '<bilagslinje>',
                'itemEnd' => '</bilagslinje>',
                'contentEnd' => '</bilagslinjer>',
            ], false);


            $this->actionUpdateFromFiles('actionUpdateAccounting');
        }

        return;
    }

    /**
     * Update Accounting
     * @param array|false $accs assoc array of data
     * @param bool $isShort diplay more info if false , or contain number of files , see: actionUpdateFromFiles()
     * @param array|false $updateActions
     * @return int exit code
     * @command yii webmegler/update-accounting
     */
    public function actionUpdateAccounting($accs = false, $isShort = false, $updateActions = false)
    {
        $batchStackLimit = 10;
        // Uncomment fo test actions
        if (is_array($accs) && !count($accs)){
            echo "No Account data pass to action\n";
            return;
        }
        /** @var MultyConnection $db */
        $ds = DIRECTORY_SEPARATOR;

        $logText = date("F j, Y, g:i a") . " start Accounting\n";
        file_put_contents(
            __DIR__ . $ds . ".." .  $ds . "logs" . $ds . "log_acc.log",
            $logText,
            FILE_APPEND
        );

        // Use difference between last update and now as time range for next update
        // Or manul time range (or default) if request is forced or time range set manually

        $isShort = $isShort ? $isShort : $this->isShort;
        // TODO: Fix log functional
        $log = [
            'update' => 0,
            'new' => 0,
        ];

        if (!$accs) {
            // TODO: implement for short request
            // $reauestArgs = $this->reauestArgs[$this->companyWebId];
            // $ra="";
            // foreach ($reauestArgs as $name => $value) {
            //     $ra .= "&{$name}={$value}";
            // }
            //
            // $data = $this->get(
            //     'accounting',
            //     [
            //         'date' => $accs,
            //         'firmaId'=>$d['id_firma'],
            //         'params' => [
            //             // 'file'      => "accounting",
            //             // 'isFile'    => true,
            //             // 'timeout'   => 0,
            //         ],
            //     ],
            //     false
            // );
        }

        // Uncomment to read from file for testing
        //$props = json_decode( file_get_contents('requests-results/update_data_for_m_7000.json'), true );
        if (!isset($accs['bilagslinje'])) {
            echo "NO Accounts to update \n";
            $logMessage = date("F j, Y, g:i a") . "  NO Accounts to update \n";
            file_put_contents(Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . 'webmegler_update_accounting_log.log', $logMessage, FILE_APPEND);
            return ExitCode::OK;
        }
        $accs = $accs['bilagslinje'];

        $pCount = 0;
        $skiped = 0;
        $depPartnerMap = (new \yii\db\Query())
            ->select(['department.id_firma', 'partner.slug'])
            ->from(Department::tableName())
            ->leftJoin(Partner::tableName(), Department::tableName() . '.partner_id = ' . Partner::tableName() . '.id')
            ->groupBy(['department.id_firma'])
            ->indexBy('id_firma')
            ->all()
        ;

        if ($isShort) {echo "Account {$isShort}\n";}
        $i = 0;
        /** @var Accounting[] $accsToStore */
        $accsToStore = [];
        foreach ($accs as $jsonAcc) {
            $i++;
            // TODO: create some union function for update parts
            $pCount++;
            // if ($isShort) {echo "Account {$isShort} {$pCount}\n";}

            $partner = isset($depPartnerMap[$jsonAcc['id_firma']]) ? $depPartnerMap[$jsonAcc['id_firma']]['slug'] : false;

            if (!$partner){
                echo "skip Account from {$jsonAcc['id_firma']} firma\n";
                $skiped++;
                continue;
            }

            /**
             * Insert Data in accounting
             */
            /** @var Accounting $newAcc */
            $newAcc = self::getAccountingModel($jsonAcc, $pCount, $isShort);
            /** @var PropertyDetails $newPropD */
            $accsToStore[] = $newAcc;
            if ($i>$batchStackLimit){
                $this->batchUpdateAccounting($accsToStore, new Accounting());
                $accsToStore = [];
            }
            // $newAcc->save(false);// TODO: fix validation and remove false
        }
        $this->batchUpdateAccounting($accsToStore, new Accounting());

        /** push socket data  end */
        // Logging
        $logMessage = date("F j, Y, g:i a") . "  Update: {$log['update']}  New: {$log['new']} \n";
        file_put_contents(Yii::getAlias('@yiiroot') . $ds  . 'webmegler_update_log.log', $logMessage, FILE_APPEND);
        echo $logMessage;
        echo "Total Accounting: {$pCount} Skiped: {$skiped}\n";
        $logText = date("F j, Y, g:i a") . " END\n";
        file_put_contents(
            __DIR__ . $ds . ".." . $ds . "logs" . $ds . "log_acc.log",
            $logText,
            FILE_APPEND
        );
        return ExitCode::OK;
    }


    /**
     * Push interesenter to webmegler by id
     * Command: php yii webmegler/push-interesenter -id=18660
     */
    public function actionPushInteresenter(){
        if(!$this->id){
            echo "-id is missing";
        }
        $id = $this->id;

        $form = Forms::findOne(['id'=>$id]);
        $this->registerInteressent($form->toArray());
    }

    /**
     * Generate ulr params for request, light or default versions
     */
    private function getRequestParamsString(){
        $params = $this->reauestArgs[$this->isLightRequest ? 'light' : 'default'][$this->companyWebId];
        $ra="";
        foreach ($params as $name => $value) {
            $ra .= "&{$name}={$value}";
        }
        return $ra;
    }


    /**
     * @param bool|integer $id
     * @param bool|PropertyDetails $property
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @command php yii webmegler/update-property -id=
     */
    public function actionUpdateProperty($id = false, $property = false){
        $id = $id ? $id : $this->id;// -id=int(11)
        if($property){
            $this->companyWebId = $property->partner->wapi_id;//-cwid=int(3)
        }
        $data = $this->get('property', ["i{$id}",$this->getRequestParamsString()]);
        $this->forceUpdate = true;
        $this->actionUpdateProperties($data, true, false, true);

        return Json::encode([
            'status' => 'Try reload page.'
        ]);
    }

    /**
     * Update for sale properties
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * CMD: php yii webmegler/update-for-sale -offset=int(default:0)
     */
    public function actionUpdateForSale(){
        $offset = $this->actionOffset;
        $props = PropertyDetails::find()
            ->joinWith(['partner'])
            ->where([
                'is_visible' => 1,
                'arkivert' => 0,
                'vispaafinn' => -1,
            ])
            ->andWhere(['not', ['property_details.tinde_oppdragstype' => 'Prosjekt']])
            ->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD( STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->offset($offset);
            //TODO:: optimise current request, see: PropertyDetailsQuery.php:83 whent it will be optimised
        ;
        $props = $props->all();
        $c = $offset + count($props);
        /** @var PropertyDetails[] $props */
        foreach ($props as $i => $prop) {
            $this->companyWebId = $prop->partner->wapi_id;
            $this->actionUpdateProperty($prop->id);
            $offset++;
            echo "UPDATED: {$offset}/{$c}---------------\n";
        }
    }
}

