{{-- bener --}}

@extends('layoutsAdmin.main')
@section('content')
    <style>
        /* Gaya untuk tab aktif */
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus {
            background-color: #007BFF; /* Warna latar belakang tab aktif */
            color: #FFFFFF; /* Warna teks tab aktif */
        }
        .nav-tabs > li > a,
        .nav-tabs > li > a:hover,
        .nav-tabs > li > a:focus {
            background-color: #E0E0E0; /* Warna latar belakang tab non-aktif (abu-abu) */
            color: #333; /* Warna teks tab non-aktif */
        }

        .nav-tabs {
            border-bottom: none; /* Menghilangkan garis di bawah tab */
        }

    </style>
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
    @if (session('activated'))
                        <div class="alert alert-success" role="alert">
                            {{ session('activated') }}
                        </div>
                    @endif
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-head">         
          <div class="pad-all text-center">
            <h3>Welcome back to the Dashboard</h3>
            <p>This is your experience to manage the Sistem Informasi Akademik Application</p>
          </div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <h3 class="panel-title">Detail Absensi</h3>
                          </div>
          
                          <!--Data Table-->
                          <!--===================================================-->
                          <div class="panel-body">
                                        <div class="fixed-fluid">
                                            <div class="fixed-md-200 pull-sm-left fixed-right-border">
                                                <div style="display: flex; justify-content:center">
                                                    
                                                    <style>
                                                        .profile-grid {
                                                            display: grid;
                                                            gap: 10px;
                                                            font-size: 14px;
                                                        }
                                                    
                                                        .profile-label {
                                                            font-weight: bold;
                                                        }
                                                    </style>
                                                    
                                                    <div class="profile-card">
                                                        <div class="profile-grid">
                                                            <div class="profile-label">Sekolah:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->sekolah)
                                                                    {{ $dataGp->sekolah->nama_sekolah }}
                                                                @else
                                                                    Nama Sekolah not assigned
                                                                @endif
                                                            </div>
                                                            <div class="profile-label">Kelas:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->kelas)
                                                                    {{ $dataGp->kelas->nama_kelas }}
                                                                @else
                                                                    Nama kelas not assigned
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="profile-label">Tahun Ajaran:</div>
                                                            <div class="profile-value">{{ $dataGp->tahun_ajaran }}</div>
                                                            
                                                            <div class="profile-label">Mata Pelajaran:</div>
                                                            <div class="profile-value">{{ $dataGp->mapel->nama_pelajaran }}</div>
                                                            
                                                            <div class="profile-label">Guru:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->user)
                                                                    {{ $dataGp->user->user_name }}
                                                                @else
                                                                    Nama Guru not assigned
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class="fluid">
                                                <button style="margin-left: 50px;" type="button" data-toggle="modal" data-id="{{ $dataGp->id_gp }}" data-target="#modalAbsensi" class="btn btn-primary add-absensi">Absensi</button>
                                                <div class="container" style="margin-top: 20px;">
                                                    <ul class="nav nav-tabs" id="absensi-tabs">
                                                        @foreach ($dataAbsensi as $key => $absensi)
                                                        <li class="{{ $tab == $absensi->id_absensi ? 'active' : '' }}">
                                                            <a data-toggle="tab" href="#absensi-{{ $absensi->id_absensi }}" data-id-gp="{{ $dataGp->id_gp }}">{{ $absensi->tanggal }}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach ($dataAbsensi as $key => $absensi)
                                                            <div id="absensi-{{ $absensi->id_absensi }}" class="tab-pane {{ $tab == $absensi->id_absensi ? 'active' : '' }}">
                                                                <form method="POST">
                                                                    @csrf
                                                                    <input type="hidden" id="data_id_gp" value="{{ $dataGp->id_gp }}" name="id_gp">
                                                                    {{-- <input name="kategori" type="hidden" value="{{ $kategori->id_kn }}"> --}}
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>NIS</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Keterangan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($dataKk as $item)
                                                                                {{-- @php
                                                                                    $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($dataGp->id_gp, $kategori->id_kn, $item->nis_siswa);
                                                                                @endphp --}}
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
                                                                                            <input class="form-control" name="nilai[]" type="text" style="width: 100px;">
                                                                                        </td>                                                                                                       
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    {{-- {{ $dataKk->links('pagination::bootstrap-4') }} --}}
                                                                    <div class="text-right mt-3">
                                                                        <a href="{{ route('dataAbsensi.absensi') }}" class="btn btn-secondary">KEMBALI</a>
                                                                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                                                                        <!-- Tombol Simpan -->
                                                                        {{-- <button type="submit" class="btn btn-primary simpanBtn" data-id-gp="{{ $dataGp->id_gp }}" data-id-kn="{{ $kategori->id_kn }}">SIMPAN</button> --}}

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    
                                                </div>
                                                {{-- <div class="row" style="margin-left: 50px; margin-top: 20px;">
                                                    <ul class="nav nav-tabs" id="absensi-tabs">
                                                        @foreach ($dataAbsensi as $key => $absensi)
                                                        <li class="{{ $tab == $absensi->id_absensi ? 'active' : '' }}">
                                                            <a data-toggle="tab" href="#absensi-{{ $absensi->id_absensi }}" data-id-gp="{{ $dataGp->id_gp }}">{{ $absensi->tanggal }}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div> --}}
                                            </div>
                                            @include('dataAbsensi.modalAbsensi')
                                        </div>
                                </div>
                          <!--===================================================-->
                          <!--End Data Table-->
          
                      </div>
                  </div>
              </div>
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                </div>
                <!--===================================================-->
                <!--End page content-->

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

      
        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->

        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Ketika tombol "Add Jadwal" diklik
                $(".add-absensi").click(function () {
                    var id_gp = $(this).data('id'); // Mengambil nilai data-id dari tombol "Add Jadwal"
                    
                    // Sekarang Anda dapat menggunakan id_gp dalam modal
                    // Contoh: memasukkan id_gp ke input dengan ID "id_gp_modal"
                    $("#id_gp_modal").val(id_gp);
                    
                    // Menampilkan modal
                    $('#modalAbsensi').modal('show');
                    
                    // Debugging: Cetak id_gp ke konsol
                    console.log("id_gp yang diambil:", id_gp);
                });
            });
        </script>
    
    
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection
