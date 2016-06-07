<?php

namespace app\controllers;

use app\models\Views;
use Yii;

class ViewsController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionAddViews(){
        Yii::$app->response->headers->add('Content-type', 'text/javascript');

        if(Yii::$app->request->get() && $_GET['callback']!=''){
            $view = new Views();
            $view->x = $_GET['x'];
            $view->y = $_GET['y'];
            $view->url = $_GET['url'];
            $view->save();
        }

        return 1;
    }



}
