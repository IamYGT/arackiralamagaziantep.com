<?php

Form::Open(['id'=>'formname','method'=>'post','action'=>'gonder','token'=>true]);
Form::Input('saatkac',['placeholder'=>'E-posta','required'=>true]);
Form::Text('adisoyadi',['placeholder'=>'Adı soyadı','required'=>true]);
Form::Select('adisoyadi',['label'=>'Adı Soyadı','value'=>'Lütfen Seçiniz','required'=>true,'data'=>
    array('1'=>'Eposta',
    '2'=>'Eposta1',
    '3'=>'Eposta2',
    '4'=>'Eposta3',
    '5'=>'Eposta4',
    '6'=>'Eposta5',
    '7'=>'Eposta6')]);

Form::Text('konu',['label'=>'Konu','name'=>'']);
Form::Email('eposta',['placeholder'=>'E-posta','required'=>true]);
Form::Password('eposta',['placeholder'=>'Şifre','']);
Form::Textarea(['name'=>'aaa','placeholder'=>'E-posta']);
Form::Captcha($this->settings->security('reCAPTCHA')['sitekey']);
Form::Submit('Gönder',['label'=>'AdiSoyadi','required'=>true]);
Form::Close();
