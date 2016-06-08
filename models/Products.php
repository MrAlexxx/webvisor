<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property string $article
 * @property integer $id
 * @property integer $id_level_1
 * @property integer $id_level_2
 * @property string $name
 * @property integer $brand_id
 * @property double $price
 * @property string $value
 * @property string $value_short
 * @property string $title
 * @property integer $visible
 * @property integer $hits
 * @property string $date
 * @property integer $sale
 * @property string $recomended_products
 * @property string $keywords
 * @property string $description
 * @property string $url
 * @property integer $position
 * @property string $background
 * @property string $thumbnail
 * @property string $text_1
 * @property string $text_2
 * @property integer $a
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_level_1', 'id_level_2', 'name', 'price', 'value', 'value_short', 'title', 'date', 'description', 'url', 'a'], 'required'],
            [['id_level_1', 'id_level_2', 'brand_id', 'visible', 'hits', 'sale', 'position', 'a'], 'integer'],
            [['price'], 'number'],
            [['value', 'value_short', 'keywords', 'description', 'text_1', 'text_2'], 'string'],
            [['date'], 'safe'],
            [['article'], 'string', 'max' => 15],
            [['name', 'title', 'recomended_products', 'url', 'background', 'thumbnail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article' => 'Article',
            'id' => 'ID',
            'id_level_1' => 'Id Level 1',
            'id_level_2' => 'Id Level 2',
            'name' => 'Name',
            'brand_id' => 'Brand ID',
            'price' => 'Price',
            'value' => 'Value',
            'value_short' => 'Value Short',
            'title' => 'Title',
            'visible' => 'Visible',
            'hits' => 'Hits',
            'date' => 'Date',
            'sale' => 'Sale',
            'recomended_products' => 'Recomended Products',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'url' => 'Url',
            'position' => 'Position',
            'background' => 'Background',
            'thumbnail' => 'Thumbnail',
            'text_1' => 'Text 1',
            'text_2' => 'Text 2',
            'a' => 'A',
        ];
    }

    public static function getNames(){
        return self::find()->select('id,name')->groupBy('name')->indexBy('id')->asArray()->all();
    }

    public static function getNotUsedProducts($limit=5){
        $productsId = Order::getAllProductsId();
        return self::find()->select(['name','url','article'])->where("`id` NOT IN (".substr(implode(',',$productsId),1).")")->asArray()->limit($limit)->all();

    }
}
