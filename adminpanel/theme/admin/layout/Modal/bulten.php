
    <div class="modal"  id="<?=((isset($id)) ? $id:null)?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">E-Posta Listesi</h4>
                </div>
                <div class="modal-body">
                    <textarea style="width: 100%; height: 110px;"><?
                  $x=0;
                  if(isset($data) and is_array($data))
                  foreach ($data as $item):
                  $x++;

                  if(($x % 30) == 0 ) echo  '</textarea><textarea style="width: 100%; height: 110px;">';
                  echo $item['mail'].' , ';
                  endforeach;
                  ?>
</textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kapat</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
