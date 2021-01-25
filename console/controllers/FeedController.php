<?php

namespace console\controllers;
use console\models\Forms;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class FeedController extends Controller
{
    private $url = "https://api.meglersiden.no/api/job/leads?key=";
    private $token = "v189r3ZZP2GSq07f2Yka0UXkEUSjSuFHsDYjrKYfeYYuMUBCGLDvupGY7m6PGBj";
    private $feeds = [
        //TODO: move tokens to env file or database
        // TODO: uncomment when need to update schala feed
        // 'schala' => [
        //     'url' => 'https://api.meglersiden.no/api/job/leads',
        //     'token' => 'v189r3ZZP2GSq07f2Yka0UXkEUSjSuFHsDYjrKYfeYYuMUBCGLDvupGY7m6PGBj',
        // ],
        'partners' => [
            'url' => 'https://api.meglersiden.no/api/job/leads',
            'token' => 'NAJLMkdfSyF3zdcXP3Eg639YmPse7tL3gCPFnhNZjashDh1udfUDa9kLDGa7JZf',
        ],
    ];
    private $source = "https://meglersiden.no/";
    public function options($actionID)
    {
        return ['timeRange', 'fileNumber', 'directoryName', 'updateActions',];
    }

    public function optionAliases()
    {
        return [
            't' => 'timeRange',
            'f' => 'fileNumber',
            'd' => 'directoryName',
            'a' => 'updateActions',
        ];
    }


    /**
     * Get data from feeds and update it (Forms)
     */
    public function actionGet(){
        $report = [];
        foreach ($this->feeds as $name => $feed) {
            $report[$name]=$this->getUpdateFeed($feed);
        }
        foreach ($report as $name=>$item) {
            echo "{$name}:\n OLD:{$item['old']} NEW:{$item['new']}\n--------\n";
        }
    }

    /**
     * Get data from feed and update it (Forms)
     * @param array[] $feed
     * @return array
     */
    private function getUpdateFeed($feed){
        $data = $this->request(['url' => "{$feed['url']}?key={$feed['token']}"]);
        $data = simplexml_load_string($data,null, LIBXML_NOCDATA);
        $data = json_encode($data);
        $data = json_decode($data, true)['doc'];
        $data = $this->normaliseData($data);
        $toOldTime = strtotime("-1 Day");

        $dataMap = [];
        // Map data from source with their ids
        foreach ($data as $lead) {
            $dataMap[$lead['@attributes']['id']] = $lead;
        }

        // Exclude leads that already in DB
        $r = Forms::find()->where([
            'source_id' => array_keys($dataMap),
            'referer_source' => $this->source,
        ])->select(['id', 'source_id'])->asArray()->all();
        $r = ArrayHelper::map($r, 'source_id', 'id');
        foreach ($r as $k=>$l) {
            unset($dataMap[$k]);
        }
        $report = [
            'old'=>0,
            'new'=>0,
        ];
        foreach ($dataMap as $lead) {
            echo "{$lead['address']} : {$lead['@attributes']['id']} ";
            $feedDate = strtotime(str_replace('.', '-',$lead['@attributes']['date']));

            // Exclude lead if its too old
            if ($feedDate < $toOldTime){$report['old']++;echo "Old \n"; continue;}
            $report['new']++;
            $r = Forms::findOne(['source_id'=>$lead['@attributes']['id']]);

            if ($r){continue;echo"Exist \n";/*Ignore existing leads*/}

            $r = new Forms();
                $r->type        = Forms::$feedType;
                $r->source_id   = $lead['@attributes']['id'];
                $r->referer_source = $this->source;
                //Merge: dev-clone -> ringeliste
                $r->source      = $this->source;
                $r->message     = $lead['description'];
                $r->name        = $lead['customer']['name'];
                $r->post_number = $lead['customer']['postalcode'];
                $r->phone       = $lead['customer']['phone'];
                $r->email       = $lead['customer']['email'];
                $r->address     = $lead['customer']['address'];
                $r->created_at  =
                $r->updated_at  = strtotime(str_replace('.', '-',$lead['@attributes']['date']));
            $r->save();
            echo "added \n";
        }
        return $report;
    }

    /**
     * remove all conflicting parts from data
     * @param array[] $data
     * @return array[]
     */
    private function normaliseData($data){
        foreach ($data as $k=>$d) {
            if(!is_array($d)){

                $data[$k] = $k == 'date' ? $data[$k] : preg_replace(
                    '/\s\s+/m',// All spaces and line breacks
                    "",
                    $d
                );

                continue;
            }

            if(count($d) == 1 && isset($d[0]) && $d[0] == " "){
                $data[$k] = '';
            }else{
                $data[$k] = $this->normaliseData($d);
            }
        }
        return $data;
    }

    /**
     * @param $args [curl_setopt function values]
     * @param bool $isAuth
     * @return bool|string [answer of request]
     */
    private function request($args, $isAuth = false){

        if( isset( $args['args'] ) && is_array($args['args']) ){
            $args['args'] = http_build_query($args['args']);
        }

        $params = array(
            'url'       => array( CURLOPT_URL ),
            'isPost'    => array( CURLOPT_POST ),
            'args'      => array( CURLOPT_POSTFIELDS ),
            'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
        );

        $ch = curl_init();
        foreach ($params as $key => $param) {

            if(isset($args[$key])){
                $param[1] = $args[$key];
            }

            if(isset($param[1])){
                curl_setopt($ch, $param[0], $param[1]);
            }
        }
        $return = curl_exec($ch);
        return $return;
    }
}
