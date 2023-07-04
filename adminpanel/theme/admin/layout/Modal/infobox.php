<!-- Main content -->
<section class="content" style="min-height: 150px;">
    <!-- Info boxes -->
    <div class="row">

        <?

         if(isset($data) and is_array($data))
             foreach ($data as $item):
        echo '
             <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-'.(isset($item['color']) ? $item['color']:'aqua').'"><i class="'.(isset($item['icon']) ? $item['icon']:null).'"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">'.(isset($item['title']) ? $item['title']:null).'</span>
                    <span class="info-box-number">'.(isset($item['count']) ? $item['count']:null).'</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
            
        ';

          endforeach;
        ?>


        </div>
        </section>
        <!-- /.col -->