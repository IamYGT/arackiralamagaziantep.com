<?php


namespace AdminPanel;


class Tabs extends Settings{

    public $tabs = array();

    public function __construct($settings,$tablist=null)
    {
        parent::__construct($settings);
        $this->tabs = $tablist;
    }


    public function tabBaslik()
    {

        $text = '  <ul class="nav nav-tabs">';
        foreach ($this->settings->lang('lang') as $dil=>$title):

       $text .=' <li class="'.(($this->settings->lang()['defaultLang']==$dil) ? 'active':null).'"><a href="#'.$dil.'" data-toggle="tab" aria-expanded="true"><img src="'.$this->settings->config('cdnURL').'admin/assets/flags/'.$dil.'.png" width="25px" style="margin-right:10px;">'.$title.'</a></li>';
        endforeach;
        $text .='</ul>';

        return $text;
    }

    public function tabBaslikArray()
    {
        $x = 0;

        $text = '  <ul class="nav nav-tabs">';
        if(is_array($this->tabs))
        foreach ($this->tabs as $name=>$title):
            $x++;

            $text .=' <li class="'.(($x==1) ? 'active':'').'"><a href="#'.$name.'" data-toggle="tab" aria-expanded="true">'.$title.'</a></li>';
        endforeach;
        $text .='</ul>';

        return $text;
    }



    public  function tabContent($content=array())
    {
        $text = '<div class="nav-tabs-custom">
                '.$this->tabBaslik().'
                 <div class="tab-content">';

        foreach ($this->settings->lang('lang') as $dil=>$title):
         $text .='<div class="tab-pane '.(($this->settings->lang('defaultLang')==$dil) ? 'active':null).'" id="'.$dil.'">';
         $text .= $content[$dil]['text'];
         $text .='</div>';


         endforeach;


        $text.='</div></div>';


        return $text;
    }


    public  function tabContentArray($content=array())
    {
        $x = 0;
        $text = '<div class="nav-tabs-custom">
                '. $this->tabBaslikArray().'
                 <div class="tab-content">';
        if(is_array($this->tabs))
        foreach ($this->tabs as $name=>$title):
            $x++;
            $text .='<div class="tab-pane '.(($x==1) ? 'active':'').'" id="'.$name.'">';
            $text .= $content[$name]['text'];
            $text .='</div>';


        endforeach;


        $text.='</div></div>';


        return $text;
    }



    public  function tabData($sql,$id)
    {
        $data = array();
        $data['tr'] = $this->dbConn->tekSorgu("select * from $sql where id='$id'");
        foreach ($this->settings->lang('lang') as $dil=>$title):
            if($dil!='tr') {
                $data[$dil] = $this->dbConn->tekSorgu("select * from ".$sql."_lang where dil='$dil' and master_id='$id' limit 1");
            }
        endforeach;

        return $data;
    }







}