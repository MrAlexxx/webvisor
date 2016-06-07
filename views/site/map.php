<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-top: 5px;">Джерело: <a href="<?=$url?>"><?=$url?></a></h3>
                <a href="/click-map" class="btn-sm btn-danger pull-right">Назад</a>
            </div>
            <!-- /.box-header -->

                <div class="box-body">
                    <img src="/web/<?= $im ?>" alt="" style="width: 100%">
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-circle" style="font-size: 20px; margin-top: 9px;color: rgb(73,100,123);"></i><span class="text-black">-1 клік</span>
                            <i class="fa fa-circle" style="font-size: 20px; margin-top: 9px;color: rgb(76,175,80);"></i><span class="text-black">-2 кліка</span>
                            <i class="fa fa-circle" style="font-size: 20px; margin-top: 9px;color: rgb(225,235,59);"></i><span class="text-black">-3 кліка</span>
                            <i class="fa fa-circle" style="font-size: 20px; margin-top: 9px;color: rgb(225,125,0);"></i><span class="text-black">-4 кліка</span>
                            <i class="fa fa-circle" style="font-size: 20px; margin-top: 9px;color: rgb(230,1,1);"></i><span class="text-black">-5 і більше кліків</span>

                        </div>
                        <div class="col-md-6">
                            <a href="/web/img/rez/<?=$img_name?>" class="btn bg-olive pull-right" download>Зберегти</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer -->
        </div>

        <!-- /.box -->
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="info-box bg-olive">
            <span class="info-box-icon"><i class="fa fa-bar-chart "></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Кількість кліків:</span>
                <span class="info-box-number"><?=$qty['qty']?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?=$qty['from_all']?>%" title="Рейтинг сторінки"></div>
                </div>
                      <span class="progress-description ">
                        <?=$qty['from_all']?>% <span class=" text-sm">кліків з усього сайту</span>
                      </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
</div>
