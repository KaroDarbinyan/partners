<?php

namespace backend\controllers;

use common\models\Department;
use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\components\StaticMethods;
use common\models\Partner;
use common\models\ShopBasket;
use common\models\ShopCart;
use common\models\ShopCategory;
use common\models\ShopImage;
use common\models\ShopOrder;
use common\models\ShopProduct;
use common\models\User;
use Throwable;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\View;

/**
 * Shop controller
 */
class ShopController extends RoleController
{
    private $prefix_dir = "/shop";


    /**
     * @var bool|User
     */
    private $user = false;
    /**
     * @var bool|Department
     */
    private $office = false;
    /**
     * @var bool|Partner
     */
    private $partner = false;

    /**
     * @var bool|User
     */
    private $choosenUser = false;


    public function init()
    {


        $this->user = Yii::$app->user->identity;
        $this->office = Yii::$app->request->get("office");
        $this->partner = Yii::$app->request->get("partner");
        $this->choosenUser = Yii::$app->request->get("user");

        Yii::$app->view->params['shop'] = 'active';
        parent::init();
    }

    /**
     * @param Action $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if ($this->user) {
            $role = Yii::$app->request->get('role', $this->user->role);
            Yii::$app->user->identity->role = $role;
            if ($this->user->hasRole("broker"))
                throw new NotFoundHttpException('The requested page does not exist.');
            $this->hasAccess();
            Yii::$app->view->params['action'] = $action->id;
            Yii::$app->view->params['breadcrumbs'][] = '<span class="ml-1 mr-1">/ Shop</span>';
            Yii::$app->view->params['basket-count'] = intval($this->user->basketCount);
            $this->view->registerJsFile('/admin/js/shop.js', ['depends' => AppAsset::class]);
            $this->view->registerCssFile('/admin/css/kartik-fileinput.css', ['depends' => AppAsset::class, 'position' => View::POS_END]);
        }

        return parent::beforeAction($action);
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
                        'actions' => ['*'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
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
     * Lists all ShopProduct and ShopCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!$this->office && !$this->partner && !$this->choosenUser) {
            $this->redirect(UrlExtended::to(["index", "office" => $this->user->department->url]));
        }

        $shopCategories = ShopCategory::find();
        if (!$this->user->hasRole("superadmin")) $shopCategories->active();

        $dataProvider = new ActiveDataProvider([
            'query' => $shopCategories,
        ]);

        return $this->render("/shop/category/index", [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single ShopCategory model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCategoryView($id)
    {
        $shopCategory = $this->findCategoryModel($id);
        $shopProductQuery = ShopProduct::find()->where(["category_id" => $shopCategory->id]);

        if (!$this->user->hasRole("superadmin")) $shopProductQuery->active();


        $dataProvider = new ActiveDataProvider([
            'query' => $shopProductQuery,
        ]);


        return $this->render("/shop/category/view", [
            'model' => $shopCategory,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new ShopCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCategoryCreate()
    {
        $model = new ShopCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(UrlExtended::to(['category-view', 'id' => $model->id]));
        }

        $model->active = true;
        return $this->render("{$this->prefix_dir}/category/create", [
            'model' => $model,
            'initial' => [
                'preview' => [],
                'previewConfig' => []
            ]
        ]);
    }

    /**
     * Updates an existing ShopCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCategoryUpdate($id)
    {
        $model = $this->findCategoryModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(UrlExtended::to(['category-view', 'id' => $model->id]));
        }

        $preview = [];
        $previewConfig = [];
        if ($model->image) {
            $preview = [Html::img(ShopHelper::categoryImage($model), ['class' => 'file-preview-image kv-preview-data'])];
            $previewConfig[] = [
                'url' => UrlExtended::to(['category-image-delete']),
                'key' => $model->image->id,
            ];
        }

        return $this->render("{$this->prefix_dir}/category/update", [
            'model' => $model,
            'initial' => [
                'preview' => $preview,
                'previewConfig' => $previewConfig
            ]
        ]);
    }

    /**
     * Deletes an existing ShopCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionCategoryDelete($id)
    {
        $shopCategory = $this->findCategoryModel($id);

        foreach ($shopCategory->products as $product)
            $product->delete();

        $shopCategory->delete();
        return $this->redirect(UrlExtended::to(['index']));
    }

    /**
     * @return bool|false|int
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionCategoryImageDelete()
    {
        $key = Yii::$app->request->post('key');

        $shopImage = ShopImage::findOne($key);
        $shopImage->path = ShopHelper::categoryDir() . $shopImage->name;

        return $shopImage->delete();
    }

    /**
     * Finds the ShopCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShopCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCategoryModel($id)
    {
        $model = ShopCategory::find()->andWhere(["id" => $id]);

        if (!$this->user->hasRole("superadmin")) $model->active();

        if (($model = $model->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a single ShopProduct model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws InvalidConfigException
     */
    public function actionProductView($id)
    {
        Yii::$app->view->registerCssFile('/js/unitegallery-master/package/unitegallery/css/unite-gallery.css');
        Yii::$app->view->registerJsFile('js/unitegallery-master/package/unitegallery/js/unitegallery.min.js', ['depends' => AppAsset::class]);
        Yii::$app->view->registerJsFile('js/unitegallery-master/package/unitegallery/themes/compact/ug-theme-compact.js', ['depends' => AppAsset::class]);

        return $this->render("/shop/product/view", [
            'model' => $this->findProductModel($id),
        ]);
    }

    /**
     * Creates a new ShopProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionProductCreate()
    {
        $model = new ShopProduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(UrlExtended::to(['product-view', 'id' => $model->id]));
        }

        $model->active = true;
        $model->category_id = Yii::$app->request->get("categoryId", null);
        return $this->render("{$this->prefix_dir}/product/create", [
            'model' => $model,
            'initial' => [
                'preview' => [],
                'previewConfig' => []
            ]
        ]);
    }

    /**
     * Updates an existing ShopProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProductUpdate($id)
    {
        $model = $this->findProductModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(UrlExtended::to(['product-view', 'id' => $model->id]));
        }

        $preview = [];
        $previewConfig = [];
        $model->pictures = $model->images;
        foreach ($model->images as $image) {
            $preview[] = [Html::img(ShopHelper::productImagesDir($model) . $image->name, ['class' => 'file-preview-image kv-preview-data'])];
            $previewConfig[] = [
                'url' => UrlExtended::to(['product-image-delete', 'id' => $model->id]),
                'key' => $image->id,
                'id' => $model->id
            ];
        }

        return $this->render("{$this->prefix_dir}/product/update", [
            'model' => $model,
            'initial' => [
                'preview' => $preview,
                'previewConfig' => $previewConfig
            ]
        ]);
    }

    /**
     * Deletes an existing ShopProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionProductDelete($id)
    {
        $this->findProductModel($id)->delete();

        return $this->redirect(UrlExtended::to(['index']));
    }

    /**
     * @return bool|false|int
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionProductImageDelete()
    {
        $key = Yii::$app->request->post('key');
        $shopProduct = new ShopProduct();
        $shopProduct->id = Yii::$app->request->get('id');

        $shopImage = ShopImage::findOne($key);
        $shopImage->path = ShopHelper::productDir($shopProduct) . $shopImage->name;

        return $shopImage->delete();
    }

    /**
     * Finds the ShopProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShopProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductModel($id)
    {
        $model = ShopProduct::find()->andWhere(["id" => $id]);

        if (!$this->user->hasRole("superadmin")) $model->active();

        if (($model = $model->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Lists all ShopBasket models.
     * @return mixed
     */
    public function actionBasket()
    {
        $activeQuery = ShopBasket::find()->joinWith(['product'])
            ->andWhere(['shop_basket.user_id' => $this->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $activeQuery,
        ]);

        $shopOrder = new ShopOrder();
//        if ($this->office)
//            $shopOrder->comment = "office - {$this->office}";
//        elseif ($this->partner)
//            $shopOrder->comment = "partner - {$this->partner}";
//        elseif ($this->choosenUser)
//            $shopOrder->comment = "user - {$this->choosenUser}";
//        else $shopOrder->comment = "PARTNERS";

        return $this->render('/shop/basket/index', [
            'dataProvider' => $dataProvider,
            'order' => $shopOrder
        ]);
    }

    /**
     * Deletes an existing ShopBasket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionBasketDelete($id)
    {
        return $this->findBasketModel($id)->delete();
    }

    /**
     * Finds the ShopBasket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopBasket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findBasketModel($id)
    {

        if (($model = ShopBasket::findOne(["id" => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAddToBasket()
    {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException('The requested page does not exist.');


        Yii::$app->response->format = Response::FORMAT_JSON;
        $product_id = Yii::$app->request->get("product_id");
        $count = Yii::$app->request->get("count");

        $shopBasket = ShopBasket::findOne(['user_id' => $this->user->id, 'product_id' => $product_id]);
        if (!$shopBasket) {
            $shopBasket = new ShopBasket();
            $shopBasket->user_id = $this->user->id;
            $shopBasket->product_id = $product_id;
            $shopBasket->count = 0;
        }

        $shopBasket->count += $count;

        return [
            'success' => $shopBasket->save(),
            'count' => $this->user->basketCount
        ];
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBasketEdit()
    {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException('The requested page does not exist.');


        $id = Yii::$app->request->get("id");
        $count = Yii::$app->request->get("count");

        $shopBasket = ShopBasket::findOne(['user_id' => $this->user->id, 'id' => $id]);

        $shopBasket->count = $count;

        return $shopBasket->save();
    }

    /**
     * Creates a new ShopOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Throwable
     */
    public function actionOrderCreate()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post("products", []);
        $products = [];
        $success = false;

        $model = new ShopOrder();

        if ($model->load(Yii::$app->request->post())) {

            foreach ($post as $key => $item) {
                $value = explode(",", $item);
                $products[] = [
                    "id" => $key,
                    "count" => $value[0],
                    "sum" => $value[1]
                ];
            }

            $model->user_id = Yii::$app->user->id;
            $model->products = json_encode($products);

            if ($this->partner && ($partner = Yii::$app->partnerService->selected()) && ($partner->id === $this->user->partner->id)) {
                $model->partner_id = $partner->id;
            }

            if ($this->office && ($department = Yii::$app->departmentService->selected())) {
                if ($department->web_id === $this->user->department_id) {
                    $model->department_id = $department->id;
                }
                $model->partner_id = $department->partner_id === $this->user->partner->id ? $this->user->partner->id : null;
            }

            ShopBasket::deleteAll(['user_id' => $this->user->id, 'product_id' => array_keys($post)]);

            $success = $model->save();
        }

        return $success
            ? [
                "title" => "TAKKE",
                "status" => "success",
                "url" => UrlExtended::to(["order-history"]),
                "body" => "Søknaden din. <span class='text-primary font-weight-bold font-italic'>№ {$model->id}</span> er godkjent. <br>Vi vil kontakte deg innen kort tid"
            ]
            : [
                "title" => "FEIL",
                "status" => "error",
                "body" => "Noe gikk galt"
            ];

    }


    /**
     * Lists all ShopOrder models.
     * @return mixed
     */
    public function actionOrderHistory()
    {
        $orders_sum = 0;
        $shopOrderQuery = ShopOrder::find();

        if ($partner = Yii::$app->partnerService->selected()) {
            $shopOrderQuery->andWhere(["or",
                ['user_id' => ArrayHelper::getColumn($partner->users, "id")],
                ["partner_id" => $partner->id]
            ]);
        } else if ($department = Yii::$app->departmentService->selected()) {
            $shopOrderQuery->andWhere(["or",
                ['user_id' => ArrayHelper::getColumn($department->users, "id")],
                ["department_id" => $department->id]
            ]);
        } elseif ($this->choosenUser) {
            $user = User::findOne(["url" => $this->choosenUser]);
            $shopOrderQuery->andWhere(['user_id' => $user->id]);
        } else {
            if (!$this->user->hasRole("superadmin")) $this->redirect(UrlExtended::to(["order-history", "user" => $this->user->url]));
        }

        $shopOrderQuery = $shopOrderQuery->orderBy(['id' => SORT_DESC])->asArray();

        $dataProvider = new ActiveDataProvider([
            'query' => $shopOrderQuery,
        ]);

        $models = $dataProvider->getModels();
        foreach ($models as $key => $model) {
            $products = json_decode($model["products"], true);
            $products_sum = array_sum(ArrayHelper::getColumn($products, "sum"));
            $orders_sum += $products_sum;
            $models[$key]["sum"] = StaticMethods::number_format($products_sum) . ' NOK';
        }
        $dataProvider->setModels($models);

        return $this->render('/shop/order/index', [
            'dataProvider' => $dataProvider,
            'orders_sum' => StaticMethods::number_format($orders_sum)
        ]);
    }

    /**
     * Displays a single ShopCategory model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionOrderView($id)
    {
        $shopOrder = $this->findOrderModel($id);
        $orders_sum = 0;

        $dataProvider = new ArrayDataProvider([
            'allModels' => ShopProduct::find()->where([
                "id" => ArrayHelper::getColumn(json_decode($shopOrder->products, true), "id")
            ])->all(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $models = $dataProvider->getModels();
        $products = ArrayHelper::index(json_decode($shopOrder->products, true), "id");
        foreach ($models as $key => $model) {
            $product_sum = intval($products[$model["id"]]["sum"]);
            $orders_sum += $product_sum;
            $models[$key] = [
                "model" => $model,
                "count" => $products[$model["id"]]["count"],
                "sum" => StaticMethods::number_format($product_sum) . ' NOK'
            ];
        }
        $dataProvider->setModels($models);


        return $this->render('/shop/order/view', [
            'dataProvider' => $dataProvider,
            'shopOrder' => $shopOrder,
            'orders_sum' => StaticMethods::number_format($orders_sum)
        ]);
    }


    /**
     * Finds the ShopOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShopOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrderModel($id)
    {
        $model = ShopOrder::find()->andWhere(["id" => $id]);

        if ($partner = Yii::$app->partnerService->selected()) {
            $model->andWhere(["or",
                ['user_id' => ArrayHelper::getColumn($partner->users, "id")],
                ["partner_id" => $partner->id]
            ]);
        } else if ($department = Yii::$app->departmentService->selected()) {
            $model->andWhere(["or",
                ['user_id' => ArrayHelper::getColumn($department->users, "id")],
                ["department_id" => $department->id]
            ]);
        } else if ($this->choosenUser) {
            $user = User::findOne(["url" => $this->choosenUser]);
            $model->andWhere(['user_id' => $user->id]);
        } else {
            if (!$this->user->hasRole("superadmin")) $this->redirect(UrlExtended::to(["order-view", "user" => $this->user->url, "id" => $id]));
        }

        if (($model = $model->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @throws NotFoundHttpException
     */
    private function hasAccess()
    {
        $actions = [
            'index',
            'category-view',
            'product-view',
            'basket',
            'basket-delete',
            'add-to-basket',
            'basket-edit',
            'order-create',
            'order-history',
            'order-view'
        ];

        $accessMap = [
            'partner' => $actions,
            'director' => $actions,
            'broker' => $actions
        ];

        if ($this->user->hasRole('superadmin'))
            $this->prefix_dir .= DIRECTORY_SEPARATOR . $this->user->role;

        else if (!in_array($this->action->id, $accessMap[$this->user->role]))
            throw new NotFoundHttpException('The requested page does not exist.');


    }

}
