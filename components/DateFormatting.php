<?php

namespace app\components;

use app\models\Lang;
use Yii;

class DateFormatting
{
    public $month = [
        "Jan"=>"Січ",
        "Feb"=>"Лют",
        "Mar"=>"Бер",
        "Apr"=>"Кві",
        "May"=>"Тра",
        "Jun"=>"Чер",
        "Jul"=>"Лип",
        "Aug"=>"Серп",
        "Sep"=>"Вер",
        "Oct"=>"Жовт",
        "Nov"=>"Лист",
        "Dec"=>"Груд"
    ];
    public function changeDate ($str_date) {

        $str_date = explode(' ', $str_date);
        $str_date[1] = $this->month[$str_date[1]];
        return $str_date[0] . " " . $str_date[1] . " " . $str_date[2];

    }

    public static function makeImgNameFromUrl($url){
        //відкидаємо службову інформацію
        $url = preg_replace(Yii::$app->params['reg2'],'',$url);
        //замінюємо всі спац символи на "-"
        $img_name =  preg_replace(Yii::$app->params['reg'], '-', $url) .'.png';
        return $img_name;
    }
}