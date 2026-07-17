<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Data Kegiatan</title>

<style>

body{

font-family: DejaVu Sans;

font-size:12px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

table,th,td{

border:1px solid black;

}

th{

background:#eeeeee;

}

th,td{

padding:8px;

}

h2{

text-align:center;

margin-bottom:0;

}

p{

text-align:center;

margin-top:2px;

}

</style>

</head>

<body>

<h2>

SISTEM INFORMASI KALENDER PUBLIKASI

</h2>

<p>

Dinas Komunikasi dan Informatika Kabupaten Ngawi

</p>

<hr>

<table>

<thead>

<tr>

<th>No</th>

<th>Judul</th>

<th>Kategori</th>

<th>Instansi</th>

<th>Tanggal</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($activities as $activity)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $activity->title }}</td>

<td>{{ optional($activity->category)->name }}</td>

<td>{{ optional($activity->institution)->name }}</td>

<td>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d-m-Y') }}</td>

<td>{{ $activity->status }}</td>

</tr>

@endforeach

</tbody>

</table>

<br>

<p>

Dicetak pada :

{{ now()->format('d-m-Y H:i') }}

</p>

</body>

</html>