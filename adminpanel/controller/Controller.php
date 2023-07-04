<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 02.03.2016
 * Time: 15:28
 */

namespace AdminPanel;


class Controller  extends Settings{

    public  $class;
    public  $function;
    public  $id;
    public  $settings;
    private $classlist;
    private $err;
    private $content;

    public function __construct($get=null,$settings)
    {

       parent::__construct($settings);
        $this->settings = $settings;
        $ex = explode('.',$get);
        $ex = explode('/',$ex[0]);
        if(isset($ex[0])) $this->class = $ex[0];
        if(isset($ex[1])) $this->function = $ex[1];
        if(isset($ex[2])) $this->id = $ex[2];

        $class = '\AdminPanel\\'.$this->class;
        if(class_exists($class)):
            $this->classlist = new $class($this->settings);
            if(method_exists($this->classlist,$this->function)):
                $this->content = $this->classlist->{$this->function}($this->id);
            elseif(method_exists($this->classlist,'index')):
                $this->content = $this->classlist->index($this->id);
            else:
                $this->AuthCheck();
                $this->err =  'Hata : Sayfa Bulunamadı';
            endif;
       else:
            $this->AuthCheck();
            $this->err ='Hata: Modül Bulunamadı';
        endif;

    }

    public function files()
    {

        return ((method_exists($this->classlist,'crop')) ? true :false);
    }

    public function LoginPage()
    {
        return ((isset($this->classlist->loginPage)) ? $this->classlist->loginPage :false);
    }

    public function sayfaBaslik()
    {
        return ((isset($this->classlist->SayfaBaslik)) ? $this->classlist->SayfaBaslik :'');
    }

    public function sayfaIcBaslik()
    {
        return ((isset($this->classlist->icbaslik) and $this->classlist->icbaslik) ? $this->classlist->icbaslik :((isset($this->classlist->SayfaBaslik)) ? $this->classlist->SayfaBaslik :''));
    }

    public function CustomPageCss($url)
    {
       if(method_exists($this->classlist,'CustomPageCss')) return $this->classlist->CustomPageCss($url);
    }

    public function CustomPageJs($url)
    {
        if(method_exists($this->classlist,'CustomPageJs')) return $this->classlist->CustomPageJs($url);
    }

    public function Content()
    {

        $class = '\AdminPanel\\'.$this->class;
        if(class_exists($class)):
            if(method_exists($this->classlist,$this->function)):
                return  $this->content;
            elseif(method_exists($this->classlist,'index')):
                return $this->content;
            else:
                return $this->err ;
            endif;
        else: return $this->err; endif;


    }







} 