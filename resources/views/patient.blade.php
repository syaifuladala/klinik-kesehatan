<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Rekam Medis Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            font-family: "Inter", sans-serif;
            width: 100%;
            font-size: 12px;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header p {
            font-size: 16px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
        }

        .profile {
            background-color: #fef5ed;
            padding: 10px 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .note {
            background-color: #e5e7eb;
            margin: 20px 0px;
            border-radius: 5px;
        }

        .note td {
            padding: 10px 10px;
        }

        .note p {
            margin-bottom: 0px;
        }

        h2 {
            font-size: 16px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Data Rekam Medis Pasien</h1>
        <p>{{$data->medical_number}}</p>
    </div>

    <div class="profile">
        <table width="100%">
            <tr>
                <td>
                    <h2>Informasi Umum Pasien</h2>
                    <label>Nama</label>
                    <p>{{$data->name}}</p>
                    <label>Tempat Tanggal Lahir</label>
                    <p>{{$data->birth_place}}, {{date_format(date_create($data->birth_date), 'j F Y')}}</p>
                    <label>Jenis Kelamin</label>
                    <p>{{$data->gender}}</p>
        
                    <label>Keperluan</label>
                    <p>{{$data->type}}</p>
                </td>
                <td>
                    <h2>Identitas</h2>
                    <label>Nomor Identitas</label>
                    <p>{{$data->identity_number}} ({{$data->identity_type}})</p>
        
                    <h2>Kontak</h2>
                    <label>Nomor HP</label>
                    <p>{{$data->phone_number}}</p>
                    <label>Alamat</label>
                    <p>{{$data->address}}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="reports">
        <h2>Riwayat Pemeriksaan</h2>
        @foreach($data->medicalReports as $report)
        <table width="100%" class="note">
            <tr>
                <td width="50%">
                    <label>Tanggal Pemeriksaan</label>
                    <p>{{date_format(date_create($report->date), 'j F Y')}}</p>
                </td>
                <td width="50%">
                    <label>Nama Dokter</label>
                    <p>{{$report->user->name}}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>Catatan</label>
                    {!! $report->note !!}
                </td>
            </tr>
        </table>
        @endforeach
    </div>
</body>

</html>