<?php
namespace frontend\controllers;


use common\components\Befaring;
use common\components\StaticMethods;
use common\models\AllPostNumber;
use common\models\Department;
use common\models\LedigeStillinger;
use common\models\Partner;
use common\models\PostNumber;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\Forms;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CompanyController extends Controller
{
    /**
     * @param string $name  -> department.url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOffice($name)
    {
        $department = Department::find()
            ->joinWith(['partner'])
            ->with(['users' => function(ActiveQuery $query) {
                $query->where(['inaktiv_status' => -1]);
            }])
            ->where([Department::tableName() . '.url' => $name])
            ->andWhere(['not', ['department.id' => 114]])
            ->one();

        if(!$department) {
            throw new NotFoundHttpException();
        }

        Yii::$app->view->params['page'] = 'office';
        Yii::$app->view->title = $department->navn;
        Yii::$app->view->params['header'] = $department->short_name;
        Yii::$app->view->params['sideForm']= new Forms;
        Yii::$app->view->params['sideForm']->broker_id = $department ->web_id;

        $formModel = new Forms;
        $formModel->department_id = $department->web_id;

        return $this->render('office', compact('department', 'formModel'));
    }

    /**
     * @param string $slug
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPartner($slug)
    {   
        $partner = Partner::find()
            ->with(['users' => function(ActiveQuery $query) {
                $query->where(['inaktiv_status' => -1]);
            }])
            ->where(['slug' => $slug])
            ->andWhere(['not', ['partner.id' => 20]])
            ->one();

        if (!$partner) {
            throw new NotFoundHttpException('Ingen partner funnet!');
        }

        Yii::$app->view->params['page'] = 'partner';
        Yii::$app->view->title = $partner->name;
        Yii::$app->view->params['header'] = $partner->name;
        Yii::$app->view->params['sideForm']= new Forms;
        Yii::$app->view->params['sideForm']->broker_id = $partner->department[0]->web_id;

        $formModel = new Forms;
        $formModel->department_id = $partner->department[0]->web_id;

        return $this->render('partner', compact('partner', 'formModel'));

    }


    /**
     * @return string
     */
    public function actionOffices()
    {

        if (Yii::$app->request->isAjax){
            $keyWord = Yii::$app->request->get("search", "");
            return $this->officesSearch($keyWord);
        }

        Yii::$app->view->params['page'] = 'velkommen';
        Yii::$app->view->title = 'Kontorer';
        Yii::$app->view->params['header'] = 'VELG <b>DITT KONTOR</b>';

        $departments = Department::find()
            ->joinWith(['partner'])
            ->where(['department.inaktiv' => 0])
            ->andWhere(['not', ['department.id' => 114]])
            ->all();

        ArrayHelper::multisort($departments, "poststed", SORT_ASC);

        $groupedDepartments = [];

        foreach ($departments as $department) {
            $groupedDepartments[$department->poststed][] = [
                'partner_name' => $department->partner->name,
                'short_name' => $department->short_name,
                'url' => $department->url
            ];
        }

        return $this->render('offices', compact('groupedDepartments'));
    }

    public function actionAboutUs()
    {
        Yii::$app->view->params['page'] = 'om_oss';
        Yii::$app->view->title = 'Om oss';
        Yii::$app->view->params['header'] = 'OM <b>OSS</b> ';

        return $this->render('about-us');
    }

    /**
     * Display Company page with it's employees
     * @return string HTML
     */
    public function actionEmployees()
    {
        Yii::$app->view->params['page'] = 'ansatte';
        Yii::$app->view->title = 'Ansatte';
        Yii::$app->view->params['header'] = '<b>SAGENE</b>';

        $departments = Department::find()
            ->joinWith('authorized')
            ->with(['users' => function(ActiveQuery $users){
                $users->where(['user.inaktiv_status' => 1]);
            }])
            ->where(['department.inaktiv' => 0])
            ->orderBy(new Expression('rand()'))
            ->all();
        $formModel = new Forms();
        return $this->render('employees', compact('departments','formModel'));
    }

    /**
     * @param $navn
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBroker($navn)
    {
        if(
            !($employer = User::find()->with('department')->filterWhere(['url' => $navn])->one())
            || User::TEST_BROKER_ID == $employer->web_id
        ) {
            throw new NotFoundHttpException();
        }

        Yii::$app->view->params['page'] = 'broker';
        Yii::$app->view->title = $employer->navn;
        Yii::$app->view->params['header'] = $employer->navn;
        Yii::$app->view->params['sideForm']= new Forms();
        Yii::$app->view->params['sideForm']->broker_id = $employer->web_id;

        $formModel = new Forms();

        return $this->render('broker', compact('employer', 'formModel'));
    }

    /**
     * Display working here page.
     *
     * @return string
     */
    public function actionWorkingHere()
    {
        Yii::$app->view->params['page'] = 'join_team';
        Yii::$app->view->title = 'JOBBE HOS OSS';
        Yii::$app->view->params['header'] = 'JOBBE <b>HOS OSS</b>';

        $vacancies = LedigeStillinger::find()
            ->isActive()
            ->orderBy(['date' => SORT_DESC])
            ->all();

        $directors = User::find()
            ->where(['web_id' => [3000216, 3000234, 3000139]])
            ->all();

        $formModel = new Forms;

        return $this->render('workingHere', compact('directors','formModel', 'vacancies'));
    }

    public function actionContactUs()
    {
        Yii::$app->view->params['page'] = 'contact';
        Yii::$app->view->title = 'Kontakt';
        Yii::$app->view->params['header'] = '<b>KONTAKT</b> OSS';
        $model = new Forms();
        return $this->render('contact-us', [
            'model' => $model,
        ]);
    }

    public function actionPrivacy()
    {
        Yii::$app->view->params['bodyClass'] = 'page-static personvern';
        Yii::$app->view->params['page'] = 'static';
        Yii::$app->view->title = 'Personvern';
        Yii::$app->view->params['header'] = '<b>Personvernerklæring</b>';

        return $this->render('privacy');
    }

    public function actionPrivacy2()
    {
        Yii::$app->view->params['bodyClass'] = 'page-static personvern';
        Yii::$app->view->params['page'] = 'static';
        Yii::$app->view->title = 'Personvern';
        Yii::$app->view->params['header'] = '<b>Personvernerklæring</b>';

        return $this->render('privacy2');
    }

    public function actionOfficeEmployees()
    {
        Yii::$app->view->params['bodyClass'] = '';
        Yii::$app->view->params['page'] = 'ansatte_per_kontrol';
        Yii::$app->view->title = 'Kontor ansatte';
        Yii::$app->view->params['header'] = '<b>SAGENE</b>';

        return $this->render('office-employees');
    }

    public function actionOfficeSearch($text = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $department = Department::find()
            ->where(['like', 'navn', $text])
            ->orWhere(['like', 'poststed', $text])
            ->orWhere(['postnummer' => $text])
            ->one();

        return [
            'success' => !is_null($department),
            'department' => $department
        ];
    }

    public function officesSearch($keyWord)
    {

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

        $groupedDepartments = [];

        foreach ($departments as $department) {
            $groupedDepartments[$department->poststed][] = [
                'partner_name' => $department->partner->name,
                'short_name' => $department->short_name,
                'url' => $department->url
            ];
        }

        return $this->renderAjax('/partials/_list_office', compact('groupedDepartments'));
    }

}