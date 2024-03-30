
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SURAT PERINTAH KERJA - {{ $workorder->no ?? 'Nomor SPK' }}</title>
      <style type="text/css">
      @media screen{
      body {
        font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
        color: #000;
        background: none;
        margin: 10px;
      }
      }
      @media print{
      @page {
        size: auto;
        margin: 8mm;
      }
      body {
        font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      }
      }

      .num {
      mso-number-format:General;
      }
      .text{
      mso-number-format:"\@"
      }
      .date{
      mso-number-format:"dd\-mm\-yyyy";
      }
      .no_wrap{
      mso-wrap-style:none;
      }

    @font-face {
        font-family:"Old English Text MT";
        src: url("OLD.ttf") format("truetype");
    }


      #mykop td {
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      }

      #kopkementrian td {
      font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      }

      #kopjudul td {
      /* font: normal 30px "Old English Text MT"; */
      font: normal 30px Trebuchet MS", Verdana, Arial, Helvetica, sans-serif";
      color:green;
      }

      #kopjudul1 td {
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      font-weight: normal;
      }

      div#koptable {
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      }

      #mytable {
      /*width: 800px;*/
      padding: 0;
      margin: 0;
      page-break-inside:auto;
      /* border: 1px solid black; */
      }

      #mytable caption {
      padding: 0 0 5px 0;
      width: 700px;
      font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      text-align: right;
      }

      #mytable th {
      font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      color: #000;
      /* border: 1px solid; */
      /*border-right: 1px solid;
      border-bottom: 1px solid;*/
      /*border-top: 1px solid;*/
      letter-spacing: 2px;
      /* text-transform: uppercase; */
      text-align: center;
      font-weight: bold;
      padding: 6px 6px 6px 12px;
      /* background: #CAE8EA url(./assets/images/bg_header.jpg) no-repeat; */
      }

      #mytable th.nobg {
      /*border-top: 0;
      border-left: 0;*/
      border: 1px solid #000;
      background: none;
      font-size: large;
      font-weight: bold;
      }

      #mytable td {
      /*border-right: 1px solid #C1DAD7;
      border-bottom: 1px solid #C1DAD7;*/
      background: #fff;
      padding: 3px 3px 3px 3px;
      color: #000;
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      border: 1px solid black;
      vertical-align: middle;
      /*border-right: 1px solid black;
      border-bottom: 1px solid black;
      border-left: 1px solid black;*/
      }
      ol{
      padding-left:  13px;
      }

      ul{
      padding-left: 13px;
      }

      tr{
        page-break-inside:avoid; page-break-after:auto
      }

      #mytable td.subtotal {
      background: #FFD4AA;
      padding: 6px 6px 6px 12px;
      color: #000;
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      border: 1px solid black;
      vertical-align: middle;
      /*border-right: 1px solid black;*/
      /*border-bottom: 1px double black;
      border-right: 1px solid black;*/
      /*border-left: none;*/
      font-weight: bold;
      }

      #mytable td.footer {
      background: white;
      padding: 6px 6px 6px 12px;
      color: #4f6b72;
      font: normal 12px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      border: 1px  solid black;
      vertical-align: middle;
      }

      #mytable td.alt {
      background: #F5FAFA;
      color: #797268;
      vertical-align: middle;
      }

      #mytable td.ul {
      padding-left: 6px;
      }

      #mytable td.ol {
      padding-left: 6px;
      }


      #mytable th.spec {
      border-left: 1px solid #C1DAD7;
      border-top: 0;
      background: #fff url(./assets/images/bullet1.gif) no-repeat;
      font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      }

      #mytable th.specalt {
      border-left: 1px solid #C1DAD7;
      border-top: 0;
      background: #f5fafa url(./assets/images/bullet2.gif) no-repeat;
      font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
      color: #797268;
      }

      #logo{
      mso-ignore:vglayout;
      position:absolute;
      z-index:1;
      margin-left:40px;
      margin-top:1px;
      }

      .hidden {
        display: none;
      }

      .show {

      }

      </style>
</head>

<!-- <body onload="window.print()" width="100%"> -->
<body width="100%">
<div style="border-bottom: solid 2px red; border-top: solid 2px white">
	<table id="kopjudul" width="100%">
<tbody>
<tr>
	<td width="10%" align="right">
		<img src="https://vo.rsimalahayati.com/assets/images/logo.png" alt="" width="100" height="100">
	</td>
	<td colspan="3">
			<table style="text-align: center;">
				</table><table><tbody><tr>
						<td align="center">
                            <div id='kopjudul' style="text-align: center;">
                                <font style="font-size:100%;">&nbsp; R.S. ISLAM MALAHAYATI</font>
                            </div>
                            <font size="4">
                            <div style="text-align: center;">
                                <font face="kartika">&nbsp; &nbsp;
                                <span style="font-size: 12px;">Jl. Pangeran Diponegoro No.2 - 4, Petisah Tengah, Kec. Medan Petisah, Kota Medan</span></font>
                            </div>
                            </font>
                            <font size="2"><font face="kartika"><span style="white-space:pre"><div style="text-align: center;">Telp. 061-4518766 </div></span>
						</font></font></td>
				</tr>
			</tbody></table>
	</td>
</tr>
</tbody>
</table></div>
<div id='kopjudul1'>
		<table width="100%" style="text-align: center;">
			<tr style="border-bottom: solid 2px red;">
				<td colspan="9"><font style="text-decoration: underline; font-weight: bold;">SURAT PERINTAH KERJA</font><br>
				{{ $workorder->no ?? 'Nomor SPK'}}</td>
			</tr>

					</table>
	</div>
	<br/>
<!-- ISI -->
@php

            $spvnama = $dataspv['supervisor_nama'] ?? '';
            $spvjabat = $dataspv['supervisor_jabatan']?? '';
            $signspv = '';


            $petunama = $datapetu['petugas_nama'] ?? '';
            $petujabat = $datapetu['petugas_jabatan'] ?? '';
            $signpetu = '';

            $pelanama = $datapela['pelapor_nama'] ?? '';
            $pelaruang = $datapela['pelapor_ruangan'] ?? '';
            $signpela = '';


@endphp
	<table id="mytable" cellspacing="0" width="100%">
    <tr>
        <th colspan='9' style="text-align: left;">Yang bertanda tangan dibawah ini :<br/></th>
    </tr>
    <tr>
        <th style="text-align: left;" width="30%">Nama</th>
        <th style="text-align: left;" width="40%">: {{ $spvnama ?? 'Nama Pemberi Tugas'}}</th>
    </tr>
    <tr>
        <th style="text-align: left;" width="30%">Jabatan</th>
        <th style="text-align: left;" width="40%">: {{ $spvjabat ?? 'Nama Pemberi Tugas'}}</th>
    </tr>
    <tr><th><p></p></th></tr>
    <tr>
        <th colspan='9' style="text-align: left;">Memberikan perintah kerja kepada :<br/></th>
    </tr>
    <tr>
        <th style="text-align: left;">Nama</th>
        <th style="text-align: left;">: {{ $petunama ?? 'Nama Pemberi Tugas'}}</th>
    </tr>
    <tr>
        <th style="text-align: left;">Jabatan</th>
        <th style="text-align: left;">: {{ $petujabat ?? 'Nama Pemberi Tugas'}}</th>
    </tr>
    <tr><th><p></p></th></tr>
    <tr>
        <th colspan='9' style="text-align: left;">Untuk melaksanakan pekerjaan yang ditentukan sebagai berikut : <br/></th>
    </tr>

        <tr><th style="text-align: left;" colspan='7'>Tugas</th></tr>
        <tr>
            <th></th>
        </tr>
    <tr>
        <th colspan='9' style="text-align: left;">Demikian Surat Perintah Kerja ini dibuat untuk dapat dilaksanakan dengan sebaik - baiknya. <br/></th>
    </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th></th>
        </tr>

        <tr>
            <th align='center' width="35%">{{ $pemberi ?? 'Pemberi Tugas'}}</th><th align='center' width="35%"> {{ $pelaksana ?? 'Pelaksana Tugas'}}</th><th align='center' class='show' colspan='3'> {{ $pelapor ?? 'Pelapor'}}</th>
        </tr>
        <tr>
            <th align='center' width="35%">{{ $spvjabat ?? 'Jabatan Pemberi Tugas'}}</th><th align='center' width="35%"> {{ $petujabat ?? 'Jabatan Pelaksana Tugas'}}</th><th align='center' class='show' colspan='3'> {{ $pelaruang ?? 'Unit Kerja Pelapor'}}</th>
        </tr>
        <th align='center' width="35%">
        </th>
        <th align='center' width="35%">
        </th>
        <th align='center' class='show' colspan='3'>
        </th>
        <tr>
            <th align='center' width="35%">{{ $spvnama ?? 'Nama Pemberi Tugas'}}</th><th align='center' width="35%"> {{ $petunama ?? 'Nama Pelaksana Tugas'}}</th><th align='center' class='show' colspan='3'> {{ $pelanama ?? 'Nama Pelapor'}}</th>
        </tr>

    </table>
    <!-- EOF ISI -->
	<div>
		<table width="100%">
			<tr>
				<td  colspan='9' align="right" style="font-size:10px;">
					 [{{ \Carbon\Carbon::parse($workorder->created_at)->format('d-m-Y H:m')}}]<br><span style="font-size:9px"></span>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
