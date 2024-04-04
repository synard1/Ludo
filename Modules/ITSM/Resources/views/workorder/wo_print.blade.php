<html>
<head>
<title>SURAT PERINTAH KERJA - {{ $workorder->noworkorder ?? 'Nomor workorder' }}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, user-scalable=no,
 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="author" content="RS ISLAM MALAHAYATI">
<meta name="creator" content="RS ISLAM MALAHAYATI">
<link rel="stylesheet" type="text/css" href="{{ public_path('assets/css/workorder-css.css') }}">
</head>

<body width="100%">
<div style="border-bottom: solid 2px red; border-top: solid 2px white">
	<table id="kopjudul" width="100%">
<tbody>
<tr>
	<td width="10%" align="right">
		<img src="{{ public_path('assets/images/logo.png') }}" width='100' height='100'>
	</td>
	<td colspan="3">
			<table style="text-align: center;">
				</table><table><tbody><tr>
						<td align="center">
                            <div id='kopjudul2' style="text-align: center;">
                                <font style="font-size:100%;">&nbsp; {{ $company->name }}</font>
                            </div>
                            <font size="4">
                            <div style="text-align: center;">
                                <font face="kartika">&nbsp; &nbsp;
                                <span style="font-size: 12px;">{{ $company->address }}</span></font>
                            </div>
                            </font>
                            <font size="2"><font face="kartika"><span style="white-space:pre"><div style="text-align: center;">{{ $company->phone }} </div></span>
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
				{{ $workorder->no ?? 'Nomor workorder'}}</td>
			</tr>

					</table>
	</div>
	<br/>
<!-- ISI -->
@php
    $petujabat ='';
    $signspv = '';

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
        <th align='center' width="20%"> </th><th align='center' width="20%"> </th><th align='center' width="40%"> </th>
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
