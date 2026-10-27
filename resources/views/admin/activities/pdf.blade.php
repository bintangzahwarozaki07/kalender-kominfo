
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Undangan Kegiatan</title>
    <style>
        @page {
            margin: 1.8cm 2.3cm 2cm 2.5cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.35;
            color: #000;
        }

        .kop {
            text-align: center;
            line-height: 1.2;
        }

        .kop .pemerintah {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
        }

        .kop .dinas {
            font-size: 14pt;
            font-weight: bold;
            margin: 3px 0;
        }

        .kop .alamat {
            font-size: 10pt;
            margin: 3px 0;
        }

        .garis {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 10px 0 18px;
        }

        table {
            border-collapse: collapse;
        }

        .identitas {
            margin-bottom: 18px;
        }

        .identitas td {
            padding: 1px 4px 1px 0;
            vertical-align: top;
        }

        .identitas .label {
            width: 75px;
        }

        .identitas .colon {
            width: 12px;
        }

        .penerima {
            margin-bottom: 18px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
        }

        .nomor-surat {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p {
            margin: 8px 0;
        }

        .isi {
            text-align: justify;
        }

        .detail {
            width: 100%;
            margin: 10px 0;
        }

        .detail td {
            padding: 3px 0;
            vertical-align: top;
        }

        .detail .label {
            width: 125px;
        }

        .detail .colon {
            width: 15px;
        }

        .ttd {
            width: 45%;
            margin-left: 55%;
            margin-top: 22px;
            page-break-inside: avoid;
        }

        .ruang-ttd {
            height: 65px;
        }

        .catatan {
            margin-top: 24px;
            padding-top: 6px;
            border-top: 1px solid #999;
            font-size: 9pt;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="kop">
        <p class="pemerintah">PEMERINTAH KABUPATEN NGAWI</p>
        <p class="dinas">
            DINAS KOMUNIKASI INFORMATIKA STATISTIK DAN PERSANDIAN
        </p>
        <p class="alamat">KABUPATEN NGAWI, JAWA TIMUR</p>
    </div>

    <div class="garis"></div>

    <table class="identitas">
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td>[Isi nomor surat resmi]</td>
        </tr>
        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td>-</td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td><strong>Undangan Kegiatan</strong></td>
        </tr>
    </table>

    <div class="penerima">
        <p>Yth. <strong>[Nama atau jabatan penerima]</strong></p>
        <p>di Tempat</p>
    </div>

    <p class="judul">SURAT UNDANGAN</p>
    <p class="nomor-surat">Nomor: [Isi nomor surat resmi]</p>

    <div class="isi">
        <p>Dengan hormat,</p>

        <p>
            Sehubungan dengan akan dilaksanakannya kegiatan
            <strong>{{ $activity->title }}</strong>, kami mengundang
            Bapak/Ibu untuk hadir dan berpartisipasi dalam kegiatan
            tersebut dengan rincian sebagai berikut:
        </p>

        <table class="detail">
            <tr>
                <td class="label">Nama kegiatan</td>
                <td class="colon">:</td>
                <td>{{ $activity->title }}</td>
            </tr>
            <tr>
                <td class="label">Hari, tanggal</td>
                <td class="colon">:</td>
                <td>
                    @if($activity->activity_date)
                        {{ \Carbon\Carbon::parse($activity->activity_date)->locale('id')->translatedFormat('l, d F Y') }}
                    @else
                        Belum ditentukan
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td class="colon">:</td>
                <td>
                    @php
                        $start = $activity->start_time;
                        $end = $activity->end_time;
                        $startValid = $start && substr((string) $start, 0, 5) !== '00:00';
                        $endValid = $end && substr((string) $end, 0, 5) !== '00:00';
                    @endphp

                    @if($startValid && $endValid)
                        {{ substr((string) $start, 0, 5) }} WIB
                        sampai {{ substr((string) $end, 0, 5) }} WIB
                    @else
                        Belum ditentukan
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td>{{ $activity->location ?: 'Belum ditentukan' }}</td>
            </tr>
            <tr>
                <td class="label">Penanggung jawab</td>
                <td class="colon">:</td>
                <td>{{ $activity->person_in_charge ?: 'Belum ditentukan' }}</td>
            </tr>
            @if($activity->description)
                <tr>
                    <td class="label">Keterangan</td>
                    <td class="colon">:</td>
                    <td>{{ $activity->description }}</td>
                </tr>
            @endif
        </table>

        <p>
            Mengingat pentingnya kegiatan tersebut, kami mengharapkan
            kehadiran Bapak/Ibu tepat pada waktu yang telah ditentukan.
            Demikian surat undangan ini disampaikan. Atas perhatian
            dan kehadiran Bapak/Ibu, kami mengucapkan terima kasih.
        </p>
    </div>

    <div class="ttd">
        <p>Ngawi, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p>Hormat kami,</p>
        <p><strong>[Jabatan pejabat berwenang]</strong></p>
        <div class="ruang-ttd"></div>
        <p>
            <strong>[Nama pejabat berwenang]</strong><br>
            NIP. [Isi NIP jika diperlukan]
        </p>
    </div>

    <p class="catatan">
        Catatan: Lengkapi nomor surat, penerima, dan identitas pejabat
        yang berwenang sesuai ketentuan instansi sebelum surat digunakan
        secara resmi.
    </p>
</body>
</html>
