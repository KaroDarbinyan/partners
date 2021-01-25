<?php
namespace console\models;

use consik\yii2websocket\events\ExceptionEvent;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Yii;
use yii\helpers\ArrayHelper;

class SocketServer extends WebSocketServer
{
    public static function runSocked () {
        $socked = new SocketServer();
        $address = ArrayHelper::getValue(Yii::$app->params, 'domain');
        $socked->port = 5555;
        try {
            $socked->server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        $socked
                    )
                ),
                $socked->port,
                $address
                );
            $socked->trigger(self::EVENT_WEBSOCKET_OPEN);
            $socked->clients = new \SplObjectStorage();
            echo 'socked run  port => '.$socked->port;
            $socked->server->run();


        } catch (\Exception $e) {
            echo 'not connect'.$e->getMessage();
            $errorEvent = new ExceptionEvent([
                'exception' => $e
            ]);
            $socked->trigger(self::EVENT_WEBSOCKET_OPEN_ERROR, $errorEvent);
        }
        $socked->start();
        return $socked;
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_CLIENT_CONNECTED, function(WSClientEvent $e) {
        });
    }


    protected function getCommand(ConnectionInterface $from, $msg)
    {
        return  $this->commandEvent($from, $msg);
    }

    public function commandEvent(ConnectionInterface $client, $msg)
    {
        $dataProperties = [];
        $path = \Yii::getAlias('@console').'/runtime/propertyDetails/data.json';
        if(file_exists($path)) {
            $dataProperties = json_decode(file_get_contents($path));
        }
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '37.252.80.213' && !$dataProperties) {
            $dataProperties['3014345'] = 'Lene Brekken';
        }
        if($this->clients && $dataProperties) {
            file_put_contents($path, print_r(json_encode([]), true));
        }
        foreach ($this->clients as $chatClient) {
            foreach ($dataProperties as $key => $dataProperty) {
                $msg = sprintf("Сегодня %s продал квартиру. Поздравляем его", $dataProperty);
                $chatClient->send( $msg);
            }
        }
    }

    public function commandSetName(ConnectionInterface $client, $msg)
    {
        file_put_contents(\Yii::getAlias('@console').'/commandSetName.text', 'commandSetName');
        $client->send( $msg );
    }
}