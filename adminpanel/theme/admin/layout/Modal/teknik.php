
    <div class="modal"  id="<?=((isset($id)) ? $id:null)?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-id="" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                   <label for="adi_soyadi"></label> - <strong>Başvuru Tarihi</strong>: <label for="basvuru_tarihi"></label> <p class="pull-right durumu">Durumu :  <label for="durumu"></label></p>
                </div>
                <div class="modal-body">
         <div class="row">
          
             <div class="col-lg-5">

               <h1>İŞ BAŞVURU FORMU</h1>
             </div>
             <div class="col-lg-6 col-lg-offset-1 tarihler">
           <button type="button" class="btn btn-success pull-right yazdir"   onclick="return $.panel.Isdurum('İşe Alındı','<?=$this->BaseAdminURL()?>',1)" >İşe Alındı</button>
           <button type="button" class="btn btn-primary pull-right yazdir" style="margin-right: 10px;" onclick="return $.panel.Isdurum('Olumlu','<?=$this->BaseAdminURL()?>',2)" >Olumlu</button>
           <button type="button" class="btn btn-danger pull-right yazdir" style="margin-right: 10px;" onclick="return $.panel.Isdurum('Olumsuz','<?=$this->BaseAdminURL()?>',3)" >Olumsuz</button>
           <button type="button" class="btn btn-warning pull-right yazdir" style="margin-right: 10px;" onclick="return $.panel.Isdurum('Red Edildi','<?=$this->BaseAdminURL()?>',4)" >Red Edildi</button>
           <a target="_blank" data-url="<?=$this->BaseAdminURL('Isbasvuru/yazdir/')?>" href="#" style="margin-right: 10px;" class="btn btn-default pull-right yazdirButon">YAZDIR</a>
                  <br clear="all">
 


             </div>
         </div>
         <style>
             table tr td{
                border:1px solid #ccc;
                padding:5px;
             }

             table tr td label {
                font-weight: 500;
             }
         </style>
         <div class="row">
             <div class="col-lg-12">
              
                 <table border="0" borderColor="#ccc" cellpadding="5" class="ebat" style="width:100%;">
                     <tr>
                         <td width="35%"  colspan="5" align="center"><strong><h3>KİMLİK BİLGİLERİ</h3></strong></td>
                     </tr>
                     <tr>
                         <td width="35%"><strong>ADI SOYADI</strong></td>
                         <td colspan="4"><label for="adi_soyadi"></label></td>
                     </tr>
                     <tr>
                         <td><strong>T.C. KİMLİK NO</strong></td>
                         <td colspan="4"><label for="tc_kimlik"></label></td>
                     </tr>
                      <tr>
                         <td width="35%"><strong>CİNSİYET</strong></td>
                         <td colspan="4"><label for="cinsiyet"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>DOĞUM YERİ ve TARİHİ</strong></td>
                         <td colspan="4"><label for="dogum_yeri_ve_tarihi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ADRESİ</strong></td>
                         <td colspan="4"><label for="adresi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>CEP TELEFONU</strong></td>
                         <td colspan="4"><label for="cep_telefonu"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>EV TELEFONU</strong></td>
                         <td colspan="4"><label for="ev_telefonu"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>MESLEĞİ</strong></td>
                         <td colspan="4"><label for="meslek"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>KAN GRUBU</strong></td>
                         <td colspan="4"><label for="kan_grubu"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>BABA ADI ve MESLEĞİ</strong></td>
                         <td colspan="4"><label for="baba_adi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%" colspan="5" align="center"><strong><h3>KİŞİSEL BİLGİLER</h3></strong></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>EHLİYET DURUMU</strong></td>
                         <td colspan="4"><label for="ehliyet"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ASKERLİK DURUMU</strong></td>
                         <td colspan="4"><label for="askerlik"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ASKERLİK TECİL TARİHİ</strong></td>
                         <td colspan="4"><label for="tecil_tarihi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>KALICI RAHATSIZLIĞI</strong></td>
                         <td colspan="4"><label for="rahatsizlik"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>TAHSİL DURUMU</strong></td>
                         <td colspan="4"><label for="tahsil"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>MEDENİ HAL</strong></td>
                         <td colspan="4"><label for="medeni_hal"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ÇOCUK SAYISI</strong></td>
                         <td colspan="4"><label for="cocuk_sayisi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>AİLENİZDE ÇALIŞAN VAR MI ?</strong></td>
                         <td colspan="4"><label for="aile_calisan"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>OTURDUĞUNUZ EV</strong></td>
                         <td colspan="4"><label for="ev_durumu"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>SABIKANIZ VAR MI?</strong></td>
                         <td colspan="4"><label for="sabika"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>İCRA TAKİBİ VAR MI?</strong></td>
                         <td colspan="4"><label for="icra_takibi"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>SİGARA KULLANIR MISINIZ?</strong></td>
                         <td colspan="4"><label for="sigara_durumu"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ŞİRKETİMİZDE ÇALIŞAN YAKININIZ VAR MI?</strong></td>
                         <td colspan="4"><label for="calisan_yakin"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>HANGİ BÖLÜMDE ÇALIŞMAK İSTERSİNİZ ?</strong></td>
                         <td colspan="4"><label for="istenen_bolum"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ÜCRET BEKLENTİNİZ ?</strong></td>
                         <td colspan="4"><label for="istenen_ucret"></label></td>
                     </tr>


                    <tr>
                         <td width="35%"><strong>BİLDİĞİNİZ YABANCI DİL varsa DÜZEYİ</strong></td>
                         <td colspan="4"><label for="yabanci_dil"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>KATILDIĞINIZ KURS VE SEMİNERLER varsa SÜRELERİ ve İSİMLERİ</strong></td>
                         <td colspan="4"><label for="kurslar"></label></td>
                     </tr>

                      <tr>
                         <td width="35%"><strong>BİR DERNEK VEYA KURULUŞA ÜYE MİSİNİZ VARSA İSİMLERİ NELERDİR?</strong></td>
                         <td colspan="4"><label for="dernek"></label></td>
                     </tr>
                     

                 </table>


                 <table border="0" class="ebat" style="width:100%;">
                     <tr>
                         <td width="35%"  colspan="5" align="center"><strong><h3>GEÇMİŞTE ÇALIŞTIĞI İŞYERLERİ (1)</h3></strong></td>
                     </tr>
                     <tr>
                         <td width="35%"><strong>FİRMA ADI</strong></td>
                         <td colspan="4"><label for="firma_adi_1"></label></td>
                     </tr>
                     <tr>
                         <td><strong>İŞVEREN İSMİ</strong></td>
                         <td colspan="4"><label for="isveren_adi_1"></label></td>
                     </tr>
                      <tr>
                         <td width="35%"><strong>TELEFONU</strong></td>
                         <td colspan="4"><label for="firma_telefon_1"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>GÖREVİNİZ</strong></td>
                         <td colspan="4"><label for="firma_gorev_1"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>NET ÜCRETİNİZ</strong></td>
                         <td colspan="4"><label for="net_ucret_1"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ÇALIŞMA SÜRESİ</strong></td>
                         <td colspan="4"><label for="calisma_suresi_1"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>AYRILIŞ NEDENİ</strong></td>
                         <td colspan="4"><label for="ayrilik_nedeni_1"></label></td>
                     </tr>

                    

                 </table>

                 <table border="0" class="ebat" style="width:100%;">
                     <tr>
                         <td width="35%"  colspan="5" align="center"><strong><h3>GEÇMİŞTE ÇALIŞTIĞI İŞYERLERİ (2)</h3></strong></td>
                     </tr>
                     <tr>
                         <td width="35%"><strong>FİRMA ADI</strong></td>
                         <td colspan="4"><label for="firma_adi_2"></label></td>
                     </tr>
                     <tr>
                         <td><strong>İŞVEREN İSMİ</strong></td>
                         <td colspan="4"><label for="isveren_adi_2"></label></td>
                     </tr>
                      <tr>
                         <td width="35%"><strong>TELEFONU</strong></td>
                         <td colspan="4"><label for="firma_telefon_2"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>GÖREVİNİZ</strong></td>
                         <td colspan="4"><label for="firma_gorev_2"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>NET ÜCRETİNİZ</strong></td>
                         <td colspan="4"><label for="net_ucret_2"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ÇALIŞMA SÜRESİ</strong></td>
                         <td colspan="4"><label for="calisma_suresi_2"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>AYRILIŞ NEDENİ</strong></td>
                         <td colspan="4"><label for="ayrilik_nedeni_2"></label></td>
                     </tr>

                    

                 </table>


                 <table border="0" class="ebat" style="width:100%;">
                     <tr>
                         <td width="35%"  colspan="5" align="center"><strong><h3>GEÇMİŞTE ÇALIŞTIĞI İŞYERLERİ (3)</h3></strong></td>
                     </tr>
                     <tr>
                         <td width="35%"><strong>FİRMA ADI</strong></td>
                         <td colspan="4"><label for="firma_adi_3"></label></td>
                     </tr>
                     <tr>
                         <td><strong>İŞVEREN İSMİ</strong></td>
                         <td colspan="4"><label for="isveren_adi_3"></label></td>
                     </tr>
                      <tr>
                         <td width="35%"><strong>TELEFONU</strong></td>
                         <td colspan="4"><label for="firma_telefon_3"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>GÖREVİNİZ</strong></td>
                         <td colspan="4"><label for="firma_gorev_3"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>NET ÜCRETİNİZ</strong></td>
                         <td colspan="4"><label for="net_ucret_3"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>ÇALIŞMA SÜRESİ</strong></td>
                         <td colspan="4"><label for="calisma_suresi_3"></label></td>
                     </tr>

                     <tr>
                         <td width="35%"><strong>AYRILIŞ NEDENİ</strong></td>
                         <td colspan="4"><label for="ayrilik_nedeni_3"></label></td>
                     </tr>

                    

                 </table>

             
                
             </div>
             



         </div>


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
