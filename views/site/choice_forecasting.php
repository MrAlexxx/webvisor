<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>
<div class="row">
<div class="col-md-6">
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
        </div>
        <div class="box-body">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-6">
                    <div id="canvas-holder" style="width: 250px !important;">
                        <canvas id="chart-area" width="250" height="250"/>
                    </div>
            </div>
            <div class="col-md-5">
                <ul class="chart-legend clearfix" style="margin-top: 4rem;">
<!--                    --><?php //foreach($ratingClick as $click):?>
<!--                        <li style="font-size: 1.6rem;"><i class="fa fa-circle-o" style="color: --><?//=$click['color']?>
<!--                    --><?php //endforeach;?>

                </ul>
            </div>
        </div>

        </div>
        <!-- /.box-body -->
    </div>
</div>


    <div class="col-md-6">
        <div class="box box-success ">
            <div class="box-header with-border">
                <h3 class="box-title">Рівень продажів</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
                <div  style="width: 600px !important;">
                    <canvas id="canvas" height="306" width="405"></canvas>
                </div>
            </div>

        </div>
           </div>
</div>
<?php print_r($month)?>
<?php //$month = implode(',',$month);echo $month;?>
<script>
    var a = <?=json_encode($month)?>;
    var lineChartData = {
        labels : ["January","February","March","April","May","June","July"],
        datasets : [
            {
                label: "My Second dataset",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : [10,20,30,40,50,60,220]
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