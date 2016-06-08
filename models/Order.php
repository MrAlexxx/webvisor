<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $goods_id
 * @property string $price_goods
 * @property integer $quantity
 * @property string $ip_address
 * @property string $customer_id
 * @property string $payment
 * @property string $id_code
 * @property string $organization
 * @property string $juridical_addresses
 * @property string $delivery
 * @property string $address
 * @property string $city
 * @property string $email
 * @property string $phone
 * @property string $date
 * @property integer $quick_order
 * @property integer $status
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
            [['order_id', 'quantity', 'quick_order', 'status'], 'integer'],
            [['date', 'goods_id', 'date'], 'safe'],
            [['goods_id', 'price_goods'], 'string', 'max' => 11],
            [['ip_address', 'customer_id', 'payment', 'id_code', 'organization', 'juridical_addresses', 'delivery', 'address', 'city', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'price_goods' => 'Price Goods',
            'quantity' => 'Quantity',
            'ip_address' => 'Ip Address',
            'customer_id' => 'Customer ID',
            'payment' => 'Payment',
            'id_code' => 'Id Code',
            'organization' => 'Organization',
            'juridical_addresses' => 'Juridical Addresses',
            'delivery' => 'Delivery',
            'address' => 'Address',
            'city' => 'City',
            'email' => 'Email',
            'phone' => 'Phone',
            'date' => 'Date',
            'quick_order' => 'Quick Order',
            'status' => 'Status',
        ];
    }

    public function search($params)
    {
        $query = Order::find()->orderBy('date DESC')->groupBy('order_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 20,
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'quantity' => $this->quantity,
            'date' => $this->date,
            'quick_order' => $this->quick_order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'goods_id', $this->goods_id])
            ->andFilterWhere(['like', 'price_goods', $this->price_goods])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'customer_id', $this->customer_id])
            ->andFilterWhere(['like', 'payment', $this->payment])
            ->andFilterWhere(['like', 'id_code', $this->id_code])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'juridical_addresses', $this->juridical_addresses])
            ->andFilterWhere(['like', 'delivery', $this->delivery])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);
        return $dataProvider;
    }

    public function getParent()
    {
        return $this->hasOne(Customers::className(), ['id' => 'customer_id']);
    }

    public function getParentName()
    {
        $cust_id = $this->customer_id;

        return $cust_id ? Customers::findOne($cust_id)['full_name'] : 'Ім\'я відсутнє';
    }

    public  function getSumById(){
       return self::find()->where(['order_id'=>$this->order_id])->sum('quantity*price_goods');
    }
    public function getOrdersForPeriod($period=90){
        return Yii::$app->db2->createCommand("SELECT `order_id`,`date`,SUM(`price_goods`*`quantity`) as `sum` FROM `order` WHERE `date` >= DATE_SUB(CURRENT_DATE, INTERVAL ".$period." DAY) GROUP BY `order_id` ORDER BY `date`")->queryAll();
    }

    public static function gatSumOrders(){
        $order = [];
        $ordersDB =  Yii::$app->db2->createCommand('SELECT  SUM(`price_goods`*`quantity`) as sum, `order_id`   FROM `order` GROUP BY  `order_id`')->queryAll();
        foreach ($ordersDB as $ord) {
            $order[$ord['order_id']] = $ord['sum'];
        }
        return $order;
    }

    public static function getMonthName($date){
        $month =[
            '01'=>'Січень',
            '02'=>'Лютий',
            '03'=>'Березень',
            '04'=>'Квітень',
            '05'=>'Травень',
            '06'=>'Червень',
            '07'=>'Липень',
            '08'=>'Серпень',
            '09'=>'Вересень',
            '10'=>'Жовтень',
            '11'=>'Листопад',
            '12'=>'Грудень',
        ];

        $month_date = date("m",strtotime($date));

        return $month[$month_date];
    }

    public static function getRatingOrders(){
        return self::getOrdersForPeriod(360);
    }

    public static function getAmountByMonth($values){
        $result = [];
        $sum    = 0;
        foreach ($values as $vall) {
            foreach ($vall as $v) {
                $sum += $v[sum];
           }
            array_push($result,$sum);
        }
        return $result;
    }

    public static function getAllProductsId(){
        return self::find()->select('goods_id')->groupBy('goods_id')->column();
    }

}
