

{{-- bener --}}

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
                                    <h3 class="panel-title">Tambah Pelajaran Perkelas</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/mapelKelas/store" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control">
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
                                            <label class="col-sm-3 control-label" for="id_kelas">Nama Kelas</label>
                                            <div class="col-sm-9">
                                                <select name="id_kelas" id="id_kelas" class="form-control">
                                                    <option disabled selected>Pilih Kelas</option>
                                                    @foreach ($dataKelas as $item)
                                                        <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_kelas')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_ajaran">Tahun Ajaran</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Tahun Ajaran" name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                                                @error('tahun_ajaran')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_link">Mata Pelajaran</label>
                                            <div class="col-sm-9">
                                                <div class="checkbox-container" style=" display: flex;
                                                flex-direction: column;">
                                                    @foreach ($dataPelajaran as $item)
                                                    <div class="form-check">
                                                      <input class="form-check-input" name="id_pelajaran[]" type="checkbox" value="{{ $item->id_pelajaran }}" id="id_pelajaran">
                                                      <label class="form-check-label">{{ $item->nama_pelajaran }}</label>
                                                    </div>
                                                    @endforeach
                                                  </div>
                                                  @error('id_pelajaran')
                                                    <span class="alert text-danger">
                                                        {{ $message }}
                                                    </span>
                                                  @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('mapelKelas.index') }}" class="btn btn-secondary">KEMBALI</a>
                                        <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                        
                            </div>
                        </div>
                        @if(session('error'))
							<div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
				        @endif
                        {{-- @error('id_kelas')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                        @enderror --}}
					    
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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#id_sekolah').change(function() {
            var selectedSekolahId = $(this).val();

            // Clear and populate dataKelas dropdown
            $('#id_kelas').empty().append('<option value="">Pilih Kelas</option>');
            @foreach ($dataKelas as $kelas)
                if ('{{ $kelas->id_sekolah }}' === selectedSekolahId) {
                    $('#id_kelas').append('<option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>');
                }
            @endforeach

            // Clear and populate dataPelajaran checkbox (multiple)
            $('.checkbox-container').empty();
            @foreach ($dataPelajaran as $item)
                if ('{{ $item->sekolah->id_sekolah }}' === selectedSekolahId) {
                    $('.checkbox-container').append(`
                        <div class="form-check">
                            <input class="form-check-input" name="id_pelajaran[]" type="checkbox" value="{{ $item->id_pelajaran }}">
                            <label class="form-check-label">{{ $item->nama_pelajaran }}</label>
                        </div>
                    `);
                }
            @endforeach
        });
    });
</script>




