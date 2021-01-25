<?php

namespace frontend\controllers;

use common\components\SnsComponent;
use common\components\StaticMethods;
use common\models\Department;
use common\models\Forms;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Booking controller
 */
class BookingController extends Controller
{

    private $points = [
        "postnummer" => "",
        "department" => false,
        "tjenester" => [],
        "date" => false,
        "formName" => ""
    ];


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function init()
    {
        if (!Yii::$app->session->has("booking")) {
            Yii::$app->session->set("booking", $this->points);
        }
        parent::init();
    }


    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        $params = Yii::$app->request->isPost ? Yii::$app->request->post() : Yii::$app->request->get();
        foreach ($params as $key => $val) {
            $arr = $session->get("booking");
            $arr[$key] = $val;
            Yii::$app->session->set("booking", $arr);
        }
        $this->points = $session->get("booking");
        return parent::beforeAction($action);
    }


    /**
     * Displays main page.
     *
     * @return mixed
     */
    public function actionMain()
    {
        Yii::$app->view->params["page"] = "main";

        $data = [];
        return $this->render("index", compact("data"));
    }

    /**
     * Displays kontorer page.
     *
     * @return mixed
     */
    public function actionKontorer()
    {
        $postnummer = $this->points["postnummer"];
        $data = [];
        $departments = Department::find()->joinWith(["partner", "users", "postNumberDetails"])
            ->where(["department.postnummer" => $postnummer, "department.inaktiv" => 0])->all();

        $departments = $departments ? $departments : Department::find()
            ->joinWith(["partner", "users", "postNumberDetails"])->where(["department.inaktiv" => 0])->all();

        ArrayHelper::multisort($departments, "poststed", SORT_ASC);
        foreach ($departments as $department) {
            $data[$department->poststed][] = [
                'partner_name' => $department->partner->name,
                'short_name' => $department->short_name,
                'postnummer' => $department->postnummer,
                'url' => "/booking/select-office?department={$department->url}&postnummer={$department->postnummer}"
            ];
        }
        Yii::$app->view->params["page"] = "kontorer";
        return $this->render("index", compact("data"));
    }


    /**
     * Displays tjenester page.
     *
     * @return mixed
     */
    public function actionSelectOffice()
    {
        $session = Yii::$app->session;
        $data = $session->get("booking");
        $data["department"] = Department::find()->joinWith(["director"])
            ->where(["department.url" => Yii::$app->request->get("department")])->one();
        $session->set("booking", $data);
        return $this->redirect(["tjenester"], 301);
    }

    /**
     * Displays tjenester page.
     *
     * @return mixed
     */
    public function actionTjenester()
    {
        if (Yii::$app->request->isPost) {
            return $this->redirect(["calendar"], 301);
        }

        Yii::$app->view->params['page'] = "tjenester";
        $data = [];
        return $this->render("index", compact("data"));
    }

    /**
     * Displays calendar page.
     *
     * @return mixed
     */
    public function actionCalendar()
    {
        if (Yii::$app->request->isAjax) {
            return $this->redirect(["information"], 301);
        }

        Yii::$app->view->params['page'] = "calendar";

        $data = [];
        return $this->render("index", compact("data"));
    }

    /**
     * Displays meglerbooking page.
     *
     * @return mixed
     */
    public function actionMegler()
    {
        Yii::$app->view->params['page'] = 'verdivurdering';
        Yii::$app->view->title = 'Meglerbooking';
        Yii::$app->view->params['header'] = '<b>Meglerbooking</b>';
        Yii::$app->view->params['render_form'] = '_form';
        Yii::$app->view->params['meglerbooking_bg'] = 'meglerbooking_bg.jpg';
        $model = new Forms();

        return $this->render("megler", compact("model"));
    }

    /**
     * Displays meglerbooking-v1 page.
     *
     * @return mixed
     */
    public function actionMeglerV1()
    {
        Yii::$app->view->params['page'] = 'verdivurdering';
        Yii::$app->view->title = 'Meglerbooking';
        Yii::$app->view->params['header'] = '<b>Meglerbooking</b>';
        Yii::$app->view->params['render_form'] = '_form_v1';
        $model = new Forms();

        return $this->render("megler", compact("model"));
    }


    /**
     * Displays information page.
     *
     * @return mixed
     */
    public function actionInformation()
    {

        $data = new Forms();
        $department = $this->points["department"];
        $data->type = "meglerbooking";
        $data->post_number = $this->points["postnummer"];
        $data->department_id = $department->web_id;
        $data->broker_id = $department->avdelingsleder;
        $data->message = implode("\n", [
            "office: {$department->navn}",
            "broker: {$department->director->navn}",
            "tjenester: " . implode(",  ", $this->points["tjenester"]),
            "postnummer: {$department->postnummer}",
            "date: " . date("d.m.Y", $this->points['date'])
        ]);


        Yii::$app->view->params['page'] = "information";

        return $this->render("index", compact("data"));
    }


    /**
     * Displays confirmation page.
     *
     * @return mixed
     */
    public function actionConfirmation()
    {

        Yii::$app->view->params['page'] = "confirmation";

        $data = Yii::$app->session->get("booking");

        return $this->render("index", compact("data"));
    }


}
