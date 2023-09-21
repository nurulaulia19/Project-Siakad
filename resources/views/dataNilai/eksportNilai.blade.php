<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Add borders to the entire table */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
            
        }

        /* Style for table header cells */
        .table-bordered th {
            border: 1px solid black;
            padding: 8px;
            
        }

        /* Style for table data cells */
        .table-bordered td {
            border: 1px solid black;
            padding: 8px;

        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        .profile-label {
            flex: 1;
            font-weight: bold;
        }

        .profile-value {
            flex: 2;
            text-align: right;
        }

        /* Optional: Add spacing between label-value pairs */
        .profile-info tr + tr {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="table-responsive">
        <div class="profile-info">
            <h3 class="mb-3" style="text-align: center">Data Nilai</h3>
            @foreach ([
                'Sekolah' => $dataGp->sekolah ? $dataGp->sekolah->nama_sekolah : 'Nama Sekolah not assigned',
                'Kelas' => $dataGp->kelas ? $dataGp->kelas->nama_kelas : 'Nama kelas not assigned',
                'Tahun Ajaran' => $dataGp->tahun_ajaran,
                'Mata Pelajaran' => $dataGp->mapel->nama_pelajaran,
                'Guru' => $dataGp->user ? $dataGp->user->user_name : 'Nama Guru not assigned',
            ] as $label => $value)
            <div class="profile-label">{{ $label }}:</div>
            <div class="profile-value">{{ $value }}</div>
            @endforeach
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">NIS</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataKk as $item)
                @php
                    $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($dataGp->id_gp, $dataKn->id_kn, $item->nis_siswa);
                @endphp
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $item->nis_siswa }}</td>
                        <td style="text-align: center;">
                            @if ($item->siswa)
                                {{ $item->siswa->nama_siswa }}
                            @else
                                Siswa not found
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $nilai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>