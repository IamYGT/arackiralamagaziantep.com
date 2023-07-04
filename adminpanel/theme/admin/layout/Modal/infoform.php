<div class="col-md-3" style="padding: 0px;">
    <div class="box <?=(($this->get_element('BoxColor')) ? $this->get_element('BoxColor'):null)?>">
        <div class="box-header with-border">
            <h3 class="box-title"><?=(isset($title) ? $title:null)?></h3>

            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <?=(isset($govde) ? $govde:null)?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>