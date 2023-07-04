<section class="content" style="min-height: 150px;">
    <div class="row">
        <?

         if(isset($data) and is_array($data))
             foreach ($data as $item):
        echo '
             <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-'.(isset($item['color']) ? $item['color']:'aqua').'">
                <div class="inner">
                    <h3>'.(isset($item['count']) ? $item['count']:null).'</h3>
                    <p>'.(isset($item['title']) ? $item['title']:null).'</p>
                </div>
                <!-- /.info-box-content -->
            <div class="icon">
             <i class="'.(isset($item['icon']) ? $item['icon']:null).'"></i>
            </div>
             '.((isset($item['link']) and is_array($item['link'])) ? '<a href="'.((isset($item['link']['href']) ? $item['link']['href']:'#')).'" class="small-box-footer">'.((isset($item['link']['title']) ? $item['link']['title']:null)).' <i class="'.((isset($item['link']['icon']) ? $item['link']['icon']:'fa fa-arrow-circle-right')).'"></i></a>':null).'
            </div>
            <!-- /.info-box -->
        </div>
        ';
          endforeach;
        ?>
        </div>
        </section>
        <!-- /.col -->
