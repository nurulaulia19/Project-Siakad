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

    </style>
</head>
<body>
    <div class="tab-content">
        @foreach ($dataKn as $key => $kategori)
            <div id="kategori-{{ $kategori->id_kn }}" class="tab-pane {{ $tab == $kategori->id_kn ? 'active' : '' }}">
            {{-- <div id="kategori-{{ $kategori->id_kn }}" class="tab-pane {{ $tab == $kategori->id_kn || ($tab === null && $key === 0) ? 'active' : '' }}"> --}}
                <form action="{{ route('dataNilai.store') }}" method="POST">
                    @csrf
                    {{-- <input name="id_gp" type="text" value="{{ $item->id_gp }}" readonly> --}}
                    <input type="hidden" id="data_id_gp" value="{{ $dataGp->id_gp }}" name="id_gp">
                    <input name="kategori" type="hidden" value="{{ $kategori->id_kn }}">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKk as $item)
                                @php
                                    $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($dataGp->id_gp, $kategori->id_kn, $item->nis_siswa);
                                @endphp
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">
                                            {{ $item->nis_siswa }}
                                            <input name="nis_siswa[]" type="hidden" value="{{ $item->nis_siswa }}" readonly>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($item->siswa)
                                                {{ $item->siswa->nama_siswa }}
                                            @else
                                                Siswa not found
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <input class="form-control" value="{{ $nilai }}" name="nilai[]" type="text" style="width: 100px;">
                                        </td>                                                                                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>