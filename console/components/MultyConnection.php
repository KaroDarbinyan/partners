<?php
namespace console\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\caching\CacheInterface;
use yii\db\Connection;
use yii\db\Exception;

class MultyConnection extends Connection {

    private $multyPdos;
    private $activeConnection;
    public $multyConnections;

    public function setActiveConnection($connectionName){
        if(!isset($this->multyConnections[$connectionName])){return;}
        $this->activeConnection = $connectionName;
        $this->dsn = $this->multyConnections[$connectionName]['dsn'];
        $this->username = $this->multyConnections[$connectionName]['username'];
        $this->password = $this->multyConnections[$connectionName]['password'];
        $this->charset = $this->multyConnections[$connectionName]['charset'];
    }
    public function getActiveConnection(){
        return $this->activeConnection;
    }
    public function init(){
        parent::init();
        $this->activeConnection = 'main';
        $this->multyConnections['main'] = [
            'dsn' => $this->dsn,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset,
        ];
        
    }


    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function open()
    {
        if (
            isset($this->multyPdos[$this->activeConnection])
            && $this->multyPdos[$this->activeConnection]
        ) {
            $this->pdo = $this->multyPdos[$this->activeConnection];
            return;
        }
        if (!empty($this->masters)) {
            $db = $this->getMaster();
            if ($db !== null) {
                $this->pdo = $db->pdo;
                return;
            }

            throw new InvalidConfigException('None of the master DB servers is available.');
        }

        if (empty($this->dsn)) {
            throw new InvalidConfigException('Connection::dsn cannot be empty.');
        }

        $token = 'Opening DB connection: ' . $this->dsn;
        $enableProfiling = $this->enableProfiling;
        try {
            if ($this->enableLogging) {
                Yii::info($token, __METHOD__);
            }

            if ($enableProfiling) {
                Yii::beginProfile($token, __METHOD__);
            }

            $this->pdo = $this->createPdoInstance();
            $this->initConnection();

            if ($enableProfiling) {
                Yii::endProfile($token, __METHOD__);
            }
        } catch (\PDOException $e) {
            if ($enableProfiling) {
                Yii::endProfile($token, __METHOD__);
            }

            throw new Exception($e->getMessage(), $e->errorInfo, (int) $e->getCode(), $e);
        }

        $this->multyPdos[$this->activeConnection] = $this->pdo;
    }

}