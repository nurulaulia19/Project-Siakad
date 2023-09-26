@extends('layoutsAdmin.main')
@section('content')
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
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Cek Nilai</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="{{ route('dataNilai.tampilkanNilai') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value)">
                                                    <option disabled selected>Pilih Sekolah</option>
                                                    @foreach ($dataSekolah as $item)
                                                        <option value="{{ $item->id_sekolah }}">{{ $item->nama_sekolah }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_sekolah')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nis_siswa">Nis / Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <select name="nis_siswa[]" id="demo-cs-multiselect" class="form-control" data-placeholder="Pilih Siswa...">
					                            </select>
                                                @error('nis_siswa')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary">TAMPILKAN</button>
                                    </div>
                                </form>

                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        @if($dataNilai)
                                            <div>
                                                <!-- Menampilkan informasi mata pelajaran -->
                                                <div>
                                                    <span>Nama Sekolah: </span>
                                                    @if (count($dataNilai) > 0 && $dataNilai[0]->guruPelajaran)
                                                        <span>
                                                            {{ $dataNilai[0]->guruPelajaran->sekolah->nama_sekolah }}
                                                        </span>
                                                    @else
                                                        <span>Data Guru Pelajaran Tidak Ditemukan</span>
                                                    @endif
                                                </div>
                                                <!-- Menampilkan informasi siswa -->
                                                <div>
                                                    <span>Nis Siswa: </span>
                                                    @if (count($dataNilai) > 0)
                                                        @php
                                                            $uniqueSiswa = collect($dataNilai)->unique('nis_siswa'); // Mendapatkan siswa yang unik
                                                        @endphp
                                                        @foreach ($uniqueSiswa as $siswa)
                                                            <span>
                                                                {{ $siswa->nis_siswa }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span>Data Guru Pelajaran Tidak Ditemukan</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span>Nama Siswa: </span>
                                                    @if (count($dataNilai) > 0 && $dataNilai[0]->siswa)
                                                        <span>
                                                            {{ $dataNilai[0]->siswa->nama_siswa }}
                                                        </span>
                                                    @else
                                                        <span>Data Guru Pelajaran Tidak Ditemukan</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataNilai as $item)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>  
                                                    <td style="vertical-align: middle;">
                                                        @if ($item->guruPelajaran)
                                                            {{ $item->guruPelajaran->mapel->nama_pelajaran }}
                                                        @else
                                                            Data Guru Pelajaran Tidak Ditemukan
                                                        @endif
                                                    </td>                                                    
                                                    <td style="vertical-align: middle;">{{ $item['nilai'] }}</td> 
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
    <!--===================================================-->
    <!-- END OF CONTAINER -->

    {{-- filter data kelas dan data siswa berdasarkan id sekolah --}}
    <script>
        function handleSekolahChange(sekolahID) {
            // var  = $('#sekolah').val();  
            let token = $("meta[name='csrf-token']").attr("content");  
            if (sekolahID) {
                 // Mengambil data siswa berdasarkan sekolah
                 $.ajax({
                    type: "GET",
                    url: "{{ route('kenaikanKelas.getsiswa') }}",
                    data: {
                        'sekolahID': sekolahID,
                        "_token": token
                    },
                    dataType: 'JSON',
                    beforeSend: function(){ 
                      $('ul.chosen-results').empty(); 
                      $("#demo-cs-multiselect").empty(); 
                    },
                    success: function(res2) { 
                                     
                        if (res2) {
                            console.log(res2);
                            $("#demo-cs-multiselect").empty();
                            $("#demo-cs-multiselect").append('<option disabled selected>Pilih Siswa...</option>');
                            $.each(res2, function(nama_siswa, nis_siswa) {
                                console.log(nama_siswa);
                                // $("#demo-cs-multiselect").append('<option value="'+id_siswa+'">'+nama_siswa+'</option>');
                                $("#demo-cs-multiselect").append('<option value="' + nis_siswa + '">' + nis_siswa + ' | ' + nama_siswa + '</option>');

                            });
                            $("#demo-cs-multiselect").trigger("chosen:updated");
                        } else {
                            $("#demo-cs-multiselect").empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                    }
                });
            } else {
                $("#demo-cs-multiselect").empty();
            }      
    
            
        }
    </script>
@endsection
