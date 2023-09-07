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
						<p>This is your experience to manage the Laundry Application</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Data Kenaikan Kelas</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
								<form action="{{ route('kenaikanKelas.update', $dataKk->id_kk) }}" method="POST">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value)" readonly>
                                                    <option disabled selected>Pilih Sekolah</option>
                                                    @foreach ($dataSekolah as $item)
                                                    <option value="{{ $item->id_sekolah }}" {{ $item->id_sekolah == $dataKk->id_sekolah ? 'selected' : '' }}>
                                                        {{ $item->nama_sekolah }}
                                                    </option>
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
                                            <label class="col-sm-3 control-label" for="id_kelas">Nama Kelas</label>
                                            <div class="col-sm-9">
                                                <select name="id_kelas" id="id_kelas" class="form-control" readonly>
                                                    @foreach ($dataKelas as $item)
                                                    <option value="{{ $item->id_kelas }}" {{ $item->id_kelas == $dataKk->id_kelas ? 'selected' : '' }}>
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_ajaran">Tahun Ajaran</label>
                                            <div class="col-sm-9">
                                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" readonly>
                                                    <option disabled>Pilih Tahun Ajaran</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                    @endphp
                                                    @for ($year = 2020; $year <= $currentYear; $year++)
                                                        <option value="{{ $year }}" {{ $year == $dataKk->tahun_ajaran ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('tahun_ajaran')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nis_siswa">Siswa</label>
                                            <div class="col-sm-9">
                                                <select name="nis_siswa[]" id="demo-cs-multiselect" class="form-control" data-placeholder="Pilih Siswa..." multiple>
                                                    @foreach ($dataSiswa as $siswa)
                                                        @php
                                                            $isSelected = in_array($siswa->nis_siswa, $selectedSiswaId) ? 'selected' : '';
                                                        @endphp
                                                        <option value="{{ $siswa->nis_siswa }}" {{ $isSelected }}>
                                                            {{ $siswa->nis_siswa }} | {{ $siswa->nama_siswa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('kenaikanKelas.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
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

    <!--===================================================-->
    <!-- END OF CONTAINER -->

   
    {{-- filter data kelas dan data siswa berdasarkan id sekolah --}}
    <script>
        function handleSekolahChange(sekolahID) {
            // var  = $('#sekolah').val();  
            let token = $("meta[name='csrf-token']").attr("content");  
            if (sekolahID) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kenaikanKelas.getkelas') }}",
                    data: {
                        'sekolahID': sekolahID,
                        "_token": token
                    },
                    dataType: 'JSON',
                    success: function(res) {  
                        console.log(res);             
                        if (res) {
                            $("#id_kelas").empty();
                            // $("#id_kelas").append('<option disabled selected>Pilih Kelas</option>');
                            $.each(res, function(nama_kelas, id_kelas) {
                                $("#id_kelas").append('<option value="'+id_kelas+'">'+nama_kelas+'</option>');
                            });
                        } else {
                            $("#id_kelas").empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                    }
                });
    
    
    
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
                            // $("#demo-cs-multiselect").append('<option disabled selected>Pilih Siswa</option>');
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
                $("#id_kelas").empty();
                $("#demo-cs-multiselect").empty();
            }      
    
            
        }
    </script>

     
@endsection









