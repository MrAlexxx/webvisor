<?php

namespace app\controllers;

use app\components\DateFormatting;
use app\models\Order;
use app\models\Products;
use app\models\Views;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use yii\helpers\Url;
use app\models\User;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['site/login']));
        }

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to(['site/click-map']));
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    ?>
                    <script>
                        window.location.href = "<?=Url::to(['site/click-map'])?>";
                    </script>
                    <?
                    die;
                }
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionClickMap($url=''){
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['site/login']));
        }

        if(Yii::$app->request->get('url')) {
            $view = new Views();
            Yii::$app->response->headers->set('Content-type', 'image/png');

    //форматування отриманого url
        //відкидаємо службову інформацію
             $url = preg_replace(Yii::$app->params['reg2'],'',$url);
        //замінюємо всі спац символи на "-"
            $img_name =  preg_replace(Yii::$app->params['reg'], '-', $url) .'.png';

        //нанесення кліків на зображення
            $view->addPoints($url,$img_name);

        //визначення кількості кліків
            $qty = Views::getCountClick($url);

            return $this->render('map', [
                'im' => 'img/rez/'.$img_name,
                'url' => $url,
                'img_name' => $img_name,
                'qty'=>$qty,
            ]);
        }else{

            $urlDb = Views::getAllUrl();
            $url = Views::getFileNameFromUrl($urlDb);

            $ratingClick = Views::getPopularPage();
            return $this->render('get-map', [
                'urlDb' => $url,
                'ratingClick'=>$ratingClick
            ]);
        }
    }

    public function actionChoiceForecasting(){
        $products = Products::getNames();
        $ratingDB = Order::getRatingOrders();
        $month = $rating = [];
        foreach ($ratingDB as $ord) {
            $month_temp = Order::getMonthName($ord['date']);
            $month[] = $month_temp;
            $rating[$month_temp][] = $ord;
        }

        return $this->render('choice_forecasting', [
            'products' => $products,
            'rating' => $rating,
            'month' => array_unique($month)

        ]);
    }

    public function actionForecast($id){


        return $this->render('forecast', [

        ]);
    }

}