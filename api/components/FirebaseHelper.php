<?php


namespace api\components;


use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Yii;
use yii\base\Component;

class FirebaseHelper extends Component
{

    /**
     * @var string
     */
    private $databaseUri;

    /**
     * @var Database
     */
    private $database;


    /**
     * FirebaseHelper constructor.
     */
    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromArray(Yii::$app->params["firebase_conf"]);

        $this->database = (new Factory)->withServiceAccount($serviceAccount);
    }


    /**
     * @param string $databaseUri
     */
    public function setDatabaseUri($databaseUri)
    {
        $this->databaseUri = $databaseUri;
        $this->database = $this->database->withDatabaseUri($this->databaseUri)->createDatabase();
    }


    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }


}