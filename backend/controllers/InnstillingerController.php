<?php

namespace backend\controllers;

use common\models\Department;
use common\models\Partner;
use common\models\Signatur;
use common\models\SpBoost;
use common\models\User;
use Throwable;
use Yii;
use common\models\CalendarEvent;
use common\models\CalendarEventSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InnstillingerController implements the CRUD actions for CalendarEvent model.
 */
class InnstillingerController extends Controller
{

    private $partner = false;
    private $office = false;
    private $chosenUser = false;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->office = Yii::$app->request->get('office');
        $this->partner = Yii::$app->request->get('partner');
        $this->chosenUser = Yii::$app->request->get('user');
//        Yii::$app->view->params['statistikk'] = 'active';
    }


    /**
     * Lists all CalendarEvent models.
     * @return mixed
     */
    public function actionCalendarEventIndex()
    {
        $searchModel = new CalendarEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('calendar-event/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CalendarEvent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCalendarEventView($id)
    {
        return $this->render('calendar-event/view', [
            'model' => $this->findCalendarEvent($id),
        ]);
    }

    /**
     * Creates a new CalendarEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCalendarEventCreate()
    {
        $model = new CalendarEvent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('calendar-event/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CalendarEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCalendarEventUpdate($id)
    {
        $model = $this->findCalendarEvent($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('calendar-event/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CalendarEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionCalendarEventDelete($id)
    {
        $this->findCalendarEvent($id)->delete();

        return $this->redirect(['calendar-event-index']);
    }

    /**
     * Finds the CalendarEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CalendarEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCalendarEvent($id)
    {
        if (($model = CalendarEvent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionSignatur()
    {

        $model = Signatur::findOne(["user_id" => Yii::$app->user->identity->id]) ?? new Signatur();

        if (Yii::$app->request->isAjax) {

            if ($model->load(Yii::$app->request->get())) {
                $model->user_id = Yii::$app->user->identity->id;
                return $model->save() ? "success" : "error";
            }
        }
        if ($this->chosenUser) $logo = User::findOne(['url' => $this->chosenUser])->partner->logo;
        else if ($this->partner) $logo = Partner::findOne(["id" => $this->partner])->logo;
        else if ($this->office) $logo = Department::findOne(["url" => $this->office])->partner->logo;
        else $logo = Yii::$app->user->identity->partner->logo;

        return $this->render("signatur", compact("model", "logo"));
    }


    public function actionEndrePassord()
    {

        /** @var User $model */
        $model = Yii::$app->user->identity;
        $model->setScenario(User::SCENARIO_CHANGE_PASSWORD);


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->new_password);
            return json_encode($model->save() ? "success" : $model->firstErrors);
        }

        return $this->render("endre-passord", compact("model"));
    }


    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionMarkedspakke()
    {
        if (Yii::$app->user->identity->hasRole("broker")) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model = new SpBoost();
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load($request->post())) {
            $sp_boost = SpBoost::findOne(["id" => $request->post("id")]);
            $sp_boost->price = $model->price;
            $sp_boost->partner_ids = $request->post("SpBoost")["partner_ids"] ? join(",", $request->post("SpBoost")["partner_ids"]) : null;

            return Json::encode($sp_boost->save() ? "success" : $sp_boost->getErrors());
        }

        $models = SpBoost::find()->all();

        $partners = Partner::find()->select(['name'])->indexBy('id')->column();

        return $this->render("markedspakke", compact("models", "partners"));
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBoosts()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $models = SpBoost::find()->select(["name as key", "CONCAT(name, ' ', price) as value"])->asArray()->all();

        return Json::encode(ArrayHelper::map($models, "key", "value"));
    }
}
