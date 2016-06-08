<?php

namespace app\models;

use app\components\DateFormatting;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "views".
 *
 * @property integer $id
 * @property string $url
 * @property integer $x
 * @property integer $y
 * @property integer $qty
 */
class Views extends \yii\db\ActiveRecord
{
    public $subColors = [
       [
          1=>[
              1=>"rgb(34, 141, 144)",
              2=>"rgb(50, 200, 204)"
          ],
          2=>[
              1=>"rgb(244, 67, 54)",
              2=>"rgb(237, 105, 95)"
          ],
          3=>[
              1=>"rgb(38, 179, 44)",
              2=>"rgb(89, 175, 93)"
          ],
          4=>[
              1=>"rgb(156, 39, 176)",
              2=>"rgb(155, 85, 167)"
          ],
          5=>[
              1=>"rgb(255, 235, 59)",
              2=>"rgb(249, 236, 120)"
          ],
          6=>[
              1=>"rgb(63, 81, 181)",
              2=>"rgb(109, 120, 177)"
          ],
       ]
    ];
    public $colors = [
        [
            1=>[
                "r"=>73,
                "g"=>100,
                "b"=>123,
            ],
            2=>[
                "r"=>76,
                "g"=>175,
                "b"=>80,
            ],
            3=>[
                "r"=>225,
                "g"=>235,
                "b"=>59,
            ],
            4=>[
                "r"=>225,
                "g"=>120,
                "b"=>0,
            ],
            5=>[
                "r"=>230,
                "g"=>1,
                "b"=>1,
            ],

        ]
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'views';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'x', 'y'], 'required'],
            [['url'], 'string'],
            [['x', 'y', 'qty'], 'integer'],
            [['qty'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'x' => 'X',
            'y' => 'Y',
            'qty' => 'Qty',
        ];
    }

    public static function getPoint($url){
        $point = (new Query())
            ->select('x,y,SUM(qty) as qty')
            ->from('views')
            ->where(['url'=>$url])
            ->groupBy('x,y')
            ->all();
        return $point;
    }

    public function addPoints($url,$img_name){
        $points = Views::getPoint($url);
      //визначаємо назву домена з якого прийшла картинка
        preg_match("/\/\/\w+\//", $url, $domen);

        $im = imagecreatefrompng('http:'.$domen[0].'screenshot/'.substr($img_name,7));
    //розміри картинки
        $w = imagesx($im);
        $h = imagesy($im);
    //створюємо новий повнокольоровий малюнок із заданою висотою і шириною
        $tmp = imageCreateTrueColor($w, $h);
    //наносимо кліки
        foreach ($points as $point) {

            if ($point['qty'] > 5)
                $color = imagecolorallocatealpha($im, 230, 1, 1, 95);
            else
                $color = imagecolorallocatealpha($im, $this->colors[0][$point['qty']]['r'], $this->colors[0][$point['qty']]['g'], $this->colors[0][$point['qty']]['b'], 95);

            imagefilledarc($im, $point['x'], $point['y'], 30, 30, 0, 360, $color, IMG_ARC_PIE);
        }

    //встановлюємо режим зміжування (для прозорості)
        imageAlphaBlending($tmp, false);
        imageSaveAlpha($tmp, true);
    //копіюємо зобреження у підготовлений шаблон
        imageCopyResampled($tmp, $im, 0, 0, 0, 0, $w, $h, $w, $h);
        imagepng($tmp, 'img/rez/'.$img_name);
        imagedestroy($im);
    }

    public static function getAllUrl(){
       return (new Query())
            ->select('url')
            ->from('views')
            ->groupBy('url')
            ->all();
    }

    public static function getCountClick($url){
    //визначення назви сайту
        preg_match('/[^http\/\/]\w+/',$url, $host_name);

        $click =  (new Query())
            ->select('SUM(qty) as qty')
            ->from('views')
            ->where(['url'=>$url])
            ->all()[0];

        $all_click = self::getAllClick($host_name[0]);

        if($click['qty']==0)
            $click['from_all'] = 0;
        else
            $click['from_all'] = round(($click['qty']*100)/$all_click,0);

            return $click;
    }

    public static function getAllClick($host_name=''){

        $all_click = (new Query())
            ->select('COUNT(`id`) as count')
            ->from('views');

        if($host_name)
            //визнвчаємо кількість кліків на обраному сайті
            $all_click->andFilterWhere(['like', 'url', $host_name]);

        return $all_click
            ->all()[0]['count'];
    }

    public static function getPopularPage(){
        $ratings = (new Query())
            ->select('SUM(qty) as qty, url')
            ->from('views')
            ->groupBy('url')
            ->orderBy('qty DESC')
            ->indexBy('url')
            ->limit(6)
            ->all();

        $allClick = self::getAllClick();
        foreach ($ratings as &$value) {
            $value['qty'] = floor(($value['qty']*100)/$allClick);
            $value['url'] = str_replace ('http://','',$value['url']);
        }
        $ratings = self::getDoughnutData($ratings);
        return $ratings;
    }


    public function getDoughnutData($ratings){
        $doughnutData = array();
        $color = new Views();
        $i=1;
        foreach ($ratings as $rating) {
            $doughnutData[$i]['value'] = $rating['qty'];
            $doughnutData[$i]['color'] = $color->subColors[0][$i][1];
            $doughnutData[$i]['highlight'] = $color->subColors[0][$i][2];
            $doughnutData[$i]['label'] = $rating['url'];
            $i++;
        }
       return $doughnutData;
    }

    public static function getFileNameFromUrl($urlDb){
        $date_format = new DateFormatting();
        $url = array();
        foreach($urlDb as &$img_name){
            //визначаємо назву файлу зображення
            $img_name['img'] = $date_format->makeImgNameFromUrl($img_name['url']);
            $img = "/web/img/rez/".$img_name['img'];
            $Headers = @get_headers('http://analitics'.$img);
            if(preg_match("|200|", $Headers[0])){
                //визначаємо дату створення
                preg_match('/\d{2}\s\w+\s\d{4}/',$Headers[3],$matches);
                $img_name['date'] = $date_format->changeDate($matches[0]);
                $url[] = $img_name;
            }
        }
        unset($urlDb);
        return $url;
    }

}