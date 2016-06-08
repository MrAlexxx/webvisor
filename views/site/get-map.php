<div class="row">
<div class="col-md-6">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Відслікувати активність на сайті...</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control || ml_url" placeholder="Введіть посилання...">
                        <span class="input-group-btn">
                          <a href="" class="btn bg-olive btn-flat || ml_site_url">Go</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-body -->
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Рейтинг веб-сторінок (%):</h3>
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
                    <?php foreach($ratingClick as $click):?>
                        <li style="font-size: 1.6rem;"><i class="fa fa-circle-o" style="color: <?=$click['color']?>;font-size: 2rem;margin-bottom: 1rem;"></i> <?=$click['label']?></li>
                    <?php endforeach;?>

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
                <h3 class="box-title">Історія</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
                <ul class="products-list product-list-in-box">
                    <?php foreach($urlDb as $url):?>
                        <li class="item">
                            <div class="product-img">
                                <img src="/image.php?width=50&height=50&cropratio=1:1&image=/web/img/rez/<?= $url['img']?>" alt="Product Image">
                            </div>
                            <div class="product-info">
                                <a href="<?=\yii\helpers\Url::to(['/click-map','url'=>$url['url']])?>" class="product-title">Детальніше</a>
                                    <span class="label bg-olive pull-right"><?=$url['date']?></span>
                                <span class="product-description">
                                 <?=$url['url']?>
                            </span>
                            </div>
                        </li>
                    <?php endforeach;?>
                    <!-- /.item -->
                </ul>
            </div>

        </div>
        <script>

            var doughnutData = [
            <?php $click = 0; foreach($ratingClick as $rating):?>
                {
                    value: <?=$rating['value']?>,
                    color: "<?=$rating['color']?>",
                    highlight: "<?=$rating['highlight']?>",
                    label: "<?=$rating['label']?>"
                },
                <?php $click += $rating['value'];endforeach;?>
                {
                    value: <?=100-$click?>,
                    color:"rgb(148, 148, 148)",
                    highlight: "rgb(158, 158, 158)",
                    label: "Інше"
                }

            ];

            window.onload = function(){
                var ctx = document.getElementById("chart-area").getContext("2d");
                var width = ctx.width - 100;
                var height = ctx.height - 100;
                window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true,animationSteps : 150});
            };



        </script>
        <!-- /.box -->
    </div>
</div>
