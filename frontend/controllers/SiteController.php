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
use yii\helpers\Url;
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
 * Site controller
 */
class SiteController extends Controller
{
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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        // if ($exception->statusCode === 404) {
        //     $pathInfo = Yii::$app->request->pathInfo;
        //     if (is_numeric($pathInfo)) {
        //         return $this->redirect(Url::toRoute('eiendommer/'.$pathInfo), 301);
        //     }
        //     return $this->redirect(Url::toRoute('company/offices'), 301);
        // }

        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax){
            $keyWord = Yii::$app->request->get("search", "");
            return $this->officesSearch($keyWord);
        }

        Yii::$app->view->params['bodyClass'] = 'page-main';
        Yii::$app->view->params['page'] = 'index';
        Yii::$app->view->title = 'Home';

        $departments = Department::find()
            ->where(['inaktiv' => 0])
            ->orderBy(['poststed' => SORT_ASC])
            ->all();

        return $this->render('index', compact('departments'));
    }

    /**
     * Search entities.
     *
     * @return false|string
     *
     * @throws NotFoundHttpException
     */
    public function actionSearch()
    {
        if(!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        if(!$keyWord = strtolower(Yii::$app->request->post('search'))) {
            return Json::encode([]);
        }

        return Json::encode(StaticMethods::getSearchData($keyWord));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        Yii::$app->view->params['bodyClass'] = 'page-login';
        Yii::$app->view->params['page'] = 'login';
        Yii::$app->view->title = 'Login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('site/index');
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays Some info
     * @return mixed
     */
    public function actionInfoCoronaVirus()
    {
        return $this->render('infoCoronaVirus');
    }

    public function officesSearch($keyWord)
    {
        $groupedDepartments = [];

        if ($keyWord) {
            $departments = is_numeric($keyWord) ? StaticMethods::closestDepartments($keyWord)
                : Department::find()
                    ->joinWith(["partner", "users", "postNumberDetails"])
                    ->andWhere(['department.inaktiv' => 0])
                    ->andWhere(['or',
                        ['like', "all_post_number.city", "%{$keyWord}%", false],
                        ['like', "department.navn", "%{$keyWord}%", false],
                        ['like', "user.navn", "%{$keyWord}%", false]
                    ])->all();

            ArrayHelper::multisort($departments, "poststed", SORT_ASC);
            foreach ($departments as $department) {
                $groupedDepartments[$department->poststed][] = [
                    'partner_name' => $department->partner->name,
                    'short_name' => $department->short_name,
                    'url' => $department->url
                ];
            }
        }

        return $this->renderPartial('/partials/_list_office', compact('groupedDepartments'));
    }
}
