<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <style type="text/css">
* {
	margin: 0px;
	padding: 0px;
	border: 0px;
}
body {
	font-family: Calibri, Tahoma, Arial;
	font-size: 16px;
}
.katman {
width:100% display:block;
}
table {
	width: 1000px;
	border: 1px solid #dedede;
}
 table tr td:fist-child {
width:250px;
border-right:1px solid #dedede;
}
table tr td:last-child {
	width: 550px;
}
th {
	background-color: #000;
	color: #fff;
}
table thead th {
	height: 60px;
	font-size: 30px;
}
</style>
    </head>
    <body>
    <div class="katman">
      <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
       <thead>
        <tr>
          <th colspan="2">İletişim Formu</th>
        </tr>
 </thead>
 <tbody>
        <tr>
          <td>İsim</td>
          <td><?=$isim?></td>
        </tr>
        <tr>
          <td>E-posta</td>
          <td><?=$eposta?></td>
        </tr>
        <tr>
          <td>Konu</td>
          <td><?=$konu?></td>
        </tr>
        <tr>
          <td>Mesaj</td>
          <td><?=$mesaj?></td>
        </tr>
        <tbody>
      </table>
    </div>
</body>
</html>