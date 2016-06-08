<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>
<div class="row">
<div class="col-md-4">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Дослідження продажів конкретного товару:</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group input-group-sm">
                        <?php
                        echo Select2::widget([
                            'name' => 'product',
                            'data' => ArrayHelper::map($products,'id','name'),
                            'options' => [
                                'placeholder' => 'Оберіть продукт ...',
                                'multiple' => false
                            ],
                        ]);?>
                        <span class="input-group-btn">
                          <a href="" class="btn bg-olive btn-flat || ml_prod_forecast" style="margin-left: -20px;">Go</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-body -->
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Найменш вживані продукти:</h3>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Артикул товару</th>
                                <th>Назва</th>
                                <th>Рівень популярності</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($notUsedProducts as $product):?>
                            <tr>
                                <td><a href="edelvin/goods/<?=$product['url']?>"><?=$product['article']?></a></td>
                                <td><?=$product['name']?></td>
                                <td><span class="label label-danger">Дуже низький</span></td>

                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        <!-- /.box-body -->
        </div>

    </div>
</div>


    <div class="col-md-6">
        <div class="box box-success ">
            <div class="box-header with-border">
                <h3 class="box-title">Рівень продажів <small>(грн/міс)</small></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
                <div  style="width: 600px !important;  margin: 0 auto;">
                    <canvas id="canvas" height="306" width="405"></canvas>
                </div>
            </div>

        </div>
           </div>
</div>

<script>
    var month  = <?=$month?>;
    var rating = <?=$rating?>;
    var lineChartData = {
        labels : month,
        datasets : [
            {
                label: "Рівень продажів",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : rating
            }

        ]

    }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }


</script>