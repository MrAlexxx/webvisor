<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\Order;
/* @var $searchModel app\models\Order */
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Visitors Report</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success || show_filter"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body">


                <?php Pjax::begin(['id' => 'countries']) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary'=>'',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],


                        [
                            'attribute' => 'order_id',
                            'headerOptions' => ['width' => '90'],
                        ],
                        [
                            'attribute' => 'customer_id',
                            'headerOptions' => ['width' => '200'],
                            'label'=>'Покупець',
                            'content'=>function($data){
                                return $data->getParentName() ? $data->getParentName() : "<span class='not-set'>Ім'я не вказано</span>";
                            },
                            'filter' => ArrayHelper::map(\app\models\Customers::getUserName(),'id','full_name')
                        ],
                        [

                            'attribute' => 'id_code',
                            'label'=>'Сума',
                            'headerOptions' => ['width' => '90'],
                            'content'=>function($data){
                                return $data->getSumById().' грн';
                            },
                            'filter' => false
                        ],

                        [
                            'attribute' => 'city',
                            'label'=>'Місто',
                            'content'=>function($data){
                                return $data->city ? $data->city : "<span class='not-set'>Місто не вказано</span>";
                            },
                        ],

                        'email:email:Email',
                        'phone:text:Номер тел.',
                        [
                            'attribute' => 'date',
                            'format' =>  ['raw'],
                            'headerOptions' => ['width' => '200'],
                            'label'=>'Дата',
                            'filter' =>
                                DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'date',
                                    'language' => 'uk',
                                    'type' => DatePicker::TYPE_BUTTON,
                                    'options' => ['placeholder' => 'Оберіть дату...'],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ])
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end() ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="row">


                </div>
            </div>
            <!-- /.box-footer -->
        </div>

        <!-- /.box -->
    </div>
</div>

