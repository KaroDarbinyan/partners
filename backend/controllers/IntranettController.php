<?php

namespace backend\controllers;


use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\components\SesMailer;
use common\components\SnsComponent;
use common\models\Department;
use common\models\DepartmentToNews;
use common\models\Mail;
use common\models\News;
use common\models\NewsLinks;
use common\models\Partner;
use common\models\Sms;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\validators\EmailValidator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Intranett controller
 */
class IntranettController extends RoleController
{

    private $office = false;

    public function init()
    {
        $this->view->registerJsFile('/admin/js/news.js', ['depends' => AppAsset::class]);
        $this->view->registerCssFile('/admin/css/kartik-fileinput.css');

        $this->office = Yii::$app->request->get('office');
        Yii::$app->view->params['intranett'] = 'active';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        //'actions' => ['*'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
        ];
    }

    /**
     * Profilering action.
     *
     * @return string
     */
    public function actionNyheter()
    {
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        $query = News::find()->where(['type' => 'nyheter', 'deleted' => false]);
        if (!$identity->hasRole("superadmin")) {
            $query = $query->joinWith(["roles"]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 15;
        $newsList = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('nyheter/index', compact('newsList', 'pages'));
    }

    /**
     * Profilering action.
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionNyheterView($id)
    {
        $news = $this->findModel($id);
        $news->viewings += 1;
        News::updateAll(['viewings' => $news->viewings], ['id' => $news->id]);
        return $this->render('nyheter/view', [
            'model' => $news,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionNyheterCreate()
    {
        if (Yii::$app->user->identity->hasRole("broker"))
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = new News();
        $model->setScenario(Yii::$app->user->identity->role);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (Yii::$app->user->identity->hasRole("superadmin")) {
                $post = Yii::$app->request->post();
                $model->user_role = $post["News"]["user_role"] ? implode("-", $post["News"]["user_role"]) : "";
            }
            if ($model->validate() && $model->save()) {
                $this->sendSmsAndEmail($model);
                Yii::$app->session->setFlash('success', 'success');
                $this->redirect(['/intranett/nyheter-view/', 'id' => $model->id]);
            }
        }

        Yii::$app->view->params["dir_name"] = Yii::$app->security->generateRandomString();
        Yii::$app->view->params["initial"] = ['preview' => [], 'previewConfig' => []];
        return $this->render('nyheter/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException|Exception if the model cannot be found
     */
    public function actionNyheterUpdate($id)
    {
        if (Yii::$app->user->identity->hasRole("broker"))
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        $model->setScenario(Yii::$app->user->identity->role);
        if ($model->load($post)) {
            if (Yii::$app->user->identity->hasRole("superadmin")) {
                $post = Yii::$app->request->post();
                $model->user_role = $post["News"]["user_role"] ? implode("-", $post["News"]["user_role"]) : "";
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'success');
                $this->redirect(['/intranett/nyheter-view/', 'id' => $id]);
            }
        }
        $preview = [];
        $previewConfig = [];
        $model->files = $model->newsLinks;
        foreach ($model->newsLinks as $newsLink) {
            $preview[] = $newsLink->getPath() . $newsLink->file_name;
            $previewConfig[] = [
                'url' => UrlExtended::to(['intranett/delete-file', 'id' => $model->id]),
                'key' => $newsLink->id,
                'id' => $model->id,
                'type' => $newsLink->getType(),
                'size' => $newsLink->file_size,
                'filetype' => $newsLink->getFileType(),
                'caption' => $newsLink->file_original_name,
                'filename' => $newsLink->file_name,
                'description' => $newsLink->file_desc,
            ];
        }


        Yii::$app->view->params["dir_name"] = isset($model->dir) ? $model->dir->dir_name : Yii::$app->security->generateRandomString();
        Yii::$app->view->params["initial"] = ['preview' => $preview, 'previewConfig' => $previewConfig];
        return $this->render('nyheter/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionNyheterDelete($id)
    {
        if (Yii::$app->user->identity->hasRole("broker"))
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        News::updateAll(['deleted' => true], ['id' => $model->id]);

        return $this->redirect(UrlExtended::toRoute(["/intranett/{$model->type}"]));
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $identity = Yii::$app->user->identity;
        $model = News::find();
        if (!$identity->hasRole("superadmin")) {
            $model = $model->joinWith(["roles"]);
        }

        $model = $model->andWhere(["news.id" => $id, 'deleted' => false])->one();
        /** @var News $model */
        if (DepartmentToNews::hasAccess($id) && $model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dir_name = Yii::$app->request->get("dir_name");

        $file = UploadedFile::getInstanceByName("file");

        $newsLinks = new NewsLinks([
            "dir_name" => Yii::$app->request->get("dir_name"),
            "file" => $file
        ]);
        $newsLinks->save();

        return [
            "location" => "/img/news/{$dir_name}/{$newsLinks->file_name}"
        ];
    }

    public function actionDeleteFile()
    {
        $key = Yii::$app->request->post('key');

        $newsLinks = NewsLinks::findOne($key);

        return $newsLinks->delete();

    }

    /**
     * Profilering action.
     *
     * @return string
     */
    public function actionProfilering()
    {
        $newsList = News::find()
            ->where(['type' => 'profilering', 'deleted' => false])
            ->all();

        return $this->render('profilering', compact('newsList'));
    }

    /**
     * Idedatabase action.
     *
     * @return string
     */
    public function actionIdedatabase()
    {
        $newsList = News::find()
            ->where(['type' => 'idedatabase', 'deleted' => false])
            ->orderBy(["id" => SORT_DESC])
            ->all();

        return $this->render('idedatabase', compact('newsList'));
    }

    /**
     * Profilering action.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProfileringView($id)
    {
        return $this->render('nyheter_view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Leverandører action.
     *
     * @return string
     */
    public function actionLeverandorer()
    {
        return $this->render('leverandorer');
    }

    /**
     * Markedsføring action.
     *
     * @return string
     */
    public function actionMarkedsforing()
    {
        return $this->render('markedsforing');
    }


    private function sendSmsAndEmail(News $news): void
    {
        $post = Yii::$app->request->post();
        $sms = isset($post["send_sms"]) && isset($post["sms_text"]) && $post["sms_text"] !== "";
        $email = isset($post["send_email"]) && isset($post["email_text"]) && $post["email_text"] !== "";

        if ($sms || $email) {
            $news_link = Yii::$app->request->hostInfo . UrlExtended::toRoute(['/intranett/nyheter-view/', 'id' => $news->id]);
            $users = User::find()
                ->select([
                    "user.id",
                    "user.navn",
                    "user.username",
                    "user.email",
                    "user.inaktiv",
                    "user.mobiltelefon",
                    "user.inaktiv_status",
                    "user.role",
                    "user.short_name",
                    "user.recruitdate",
                    "user.dismissaldate",
                    'FROM_UNIXTIME(recruitdate, "%d.%m.%Y") as start_job',
                    'FROM_UNIXTIME(dismissaldate, "%d.%m.%Y") as end_job'
                ])
                ->leftJoin(Department::tableName(), "user.id_avdelinger = department.web_id")
                ->leftJoin(Partner::tableName(), "department.partner_id = partner.id")
                ->andWhere(['user.role' => explode("-", $news->user_role)])
                ->andWhere(["user.inaktiv_status" => -1])
                ->andWhere(["and", ["<", "user.recruitdate", time()], ["user.dismissaldate" => null]]);

            if ($news->prt_names) $users->andWhere(["partner.name" => $news->prt_names]);
            else if ($news->dep_names)
                $users->andWhere(["department.short_name" => $news->dep_names]);

            $users = $users->groupBy("user.id")->asArray()->all();

            if ($sms) {
                $message = strpos($post["sms_text"], '{{link}}') !== false
                    ? str_replace("{{link}}", " {$news_link} ", $post["sms_text"])
                    : "{$post["sms_text"]} \n {$news_link}";

                $this->sendSms($message, $users);
            }
            if ($email) {
                $message = strpos($post["email_text"], '{{link}}') !== false
                    ? str_replace("{{link}}", " {$news_link} ", $post["email_text"])
                    : "{$post["email_text"]} \n {$news_link}";
                $this->sendEmail($message, $users, $news);
            }
        }

    }

    /**
     * @param string $message
     * @param User[] $users
     */
    private function sendSms(string $message, array $users): void
    {
        $sms = new Sms(['from' => "PARTNERS", "message" => preg_replace('/^ +| +$|( ) +/m', '$1', $message)]);

        foreach ($users as $user) {
            $sms->setAttributes(["phone" => $user["mobiltelefon"]]);
            if ($sms->validate()) {
                $smsSender = new SnsComponent();
                $smsSender->setSenderId($sms->from);
                $smsSender->publishSms($sms->message, $sms->phone);
            }
        }

    }

    /**
     * @param string $message
     * @param User[] $users
     * @param News $news
     */
    private function sendEmail(string $message, array $users, News $news): void
    {
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        $emailValidator = new EmailValidator();
        $emails = [];
        $model = new Mail([
            "subject" => "Nye nyheter",
            "from" => "{$identity->navn} <{$identity->email}>",
            "message" => $this->renderPartial("@backend/views/emails/broker/nyheter", [
                'news' => $news,
                'text' => str_replace("\n", "<br>", $message)
            ])
        ]);

        if ($model->validate() && $users) {
            foreach ($users as $user) {
//                if ($emailValidator->validate($user["email"]))
                array_push($emails, $user["email"]);
            }
            $mailer = new SesMailer();
            $mailer->sendMail($model->message, $model->subject, [$emails], $model->from);
        }

    }

}