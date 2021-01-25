<?php

namespace frontend\controllers;

use common\models\Department;
use common\models\PropertyDetails;
use common\models\User;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RedirectController extends Controller
{
    protected function getProperty($id)
    {
        $property = PropertyDetails::find()
            ->with(['user'])
            ->where(['oppdragsnummer' => $id])
            ->orWhere(['id' => $id])
            ->one();

        if (!$property) {
            throw new NotFoundHttpException();
        }

        return $property;
    }

    public function actionProperty($slug, $id)
    {
        $property = $this->getProperty($id);

        return $this->redirect($property->path(), 301);
    }

    public function actionTo($id)
    {
        $id = str_replace('-', '', $id);

        $property = $this->getProperty($id);
        $url = $property->path();

        if ($form = Yii::$app->request->get('form')) {
            if ($form === 'etaskt' || $form === 'e_takst') {
                if ($property->user) {
                    $url = Url::toRoute(['company/broker', 'navn' => $property->user->url]);
                } else {
                    $url = Url::toRoute(['sell/etakst']);
                }
            }

            $url .= "#{$form}";
        }

        return $this->redirect($url, 301);
    }

    public function actionSalgsoppgave($id)
    {
        $property = $this->getProperty($id);
        $url = $property->path();

        return $this->redirect("{$url}#salgsoppgave", 301);
    }

    public function actionNewProperties()
    {
        return $this->redirect(Url::toRoute('eiendommer/nybygg'), 301);
    }

    public function actionProperties()
    {
        return $this->redirect('/eiendommer', 301);
    }

    public function actionOffices()
    {
        return $this->redirect(Url::toRoute('company/offices'), 301);
    }

    public function actionPartner($slug)
    {
        $known = [
            'aursnespartners' => 'aursnes-partners',
            'bs-partners' => 'bakke-sorvik-partners',
            'grimsoenpartners' => 'grimsoen-partners',
            'huuspartners' => 'huus-partners',
            'leinaespartners' => 'leinaes-partners',
            'meglerhusetpartners' => 'meglerhuset-partners',
            'oldenpartners' => 'olden-partners',
            'partnerseiendomsmegling' => 'partners-eiendomsmegling',
            'gjestvangpartners' => 'partners-eiendomsmegling',
            'mollerpartners' => 'moller-partners',
        ];

        return $this->redirect(Url::toRoute(['company/partner', 'slug' => $known[$slug] ?? 'schala']), 301);
    }

    public function actionKontor($slug)
    {
        return $this->actionOffice($slug, null);
    }

    public function actionOffice($slug, $partner)
    {
        $known = [
            'carlberner' => 'oslo-carl-berner',
            'kalbakken' => 'oslo-kalbakken',
            'bjorvika' => 'oslo-bjorvika',
            'grunerlokka' => 'oslo-grunerlokka',
            'sagene' => 'oslo-sagene',
            'torshov' => 'oslo-torshov',
        ];

        return $this->redirect(Url::toRoute(['company/office', 'name' => $known[$slug] ?? $slug]), 301);
    }

    public function actionNews()
    {
        return $this->redirect('https://bolignyttpartners.no', 301);
    }

    public function actionKontakt()
    {
        return $this->redirect(Url::toRoute(['company/contact-us']), 301);
    }
}
