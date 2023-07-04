<div class=" col-lg-9 pull-left" style="padding-left: 0px;">
    <div class="box <?=(($this->get_element('BoxColor')) ? $this->get_element('BoxColor'):null)?>">
        <div class="box-header with-border">
            <h3 class="box-title"><?=((isset($icbaslik) ? $icbaslik :''))?></h3>
        </div>
        <div class="box-body">

            <div class=""><div class="form ">
                    <form action="<?=((isset($action) ? $action :''))?>"
                          id="<?=((isset($id) ? $id :''))?>"
                          class="<?=((isset($class) ? $class :''))?>"
                          method="<?=((isset($method) ? $method :''))?>"
                      <?=((isset($fileUpload) ? 'enctype="multipart/form-data"' :''))?> >
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
