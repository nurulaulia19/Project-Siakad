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
					                    <h3 class="panel-title">Detail Nilai</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
                                        <div class="fixed-fluid">
                                            <div class="fixed-md-200 pull-sm-left fixed-right-border">
                                                <div class="text-center">
                                                    @foreach ($dataGp as $item)
                                                    <div class="profile-card">
                                                        <h4 class="profile-name">
                                                            @if ($item->sekolah)
                                                            {{ $item->sekolah->nama_sekolah }}
                                                            @else
                                                            Nama Sekolah not assigned
                                                            @endif
                                                        </h4>
                                                        <div class="profile-info">
                                                            @if ($item->kelas)
                                                            <p class="profile-detail">{{ $item->kelas->nama_kelas }}</p>
                                                            @else
                                                            <p class="profile-detail">Nama kelas not assigned</p>
                                                            @endif
                                            
                                                            <p class="profile-detail">Tahun Ajaran: {{ $item->tahun_ajaran }}</p>
                                                            <p class="profile-detail">Mata Pelajaran: {{ $item->mapel->nama_pelajaran }}</p>
                                                            @if ($item->user)
                                                            <p class="profile-detail">Guru: {{ $item->user->user_name }}</p>
                                                            @else
                                                            <p class="profile-detail">Nama Guru not assigned</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr> <!-- Garis pemisah antar elemen -->
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <div class="fluid">
                                                
                                                <div class="tab-base">
					
                                                    {{-- <!--Nav Tabs-->
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#demo-lft-tab-1">Home <span class="badge badge-purple">27</span></a>
                                                        </li>
                                                        <li>
                                                            <a data-toggle="tab" href="#demo-lft-tab-2">Profile</a>
                                                        </li>
                                                        <li>
                                                            <a data-toggle="tab" href="#demo-lft-tab-3">Setting</a>
                                                        </li>
                                                    </ul>
                                        
                                                    <!--Tabs Content-->
                                                    <div class="tab-content">
                                                        <div id="demo-lft-tab-1" class="tab-pane fade active in">
                                                            <p class="text-main text-semibold">First Tab Content</p>
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                                                        </div>
                                                        <div id="demo-lft-tab-2" class="tab-pane fade">
                                                            <p class="text-main text-semibold">Second Tab Content</p>
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                                                        </div>
                                                        <div id="demo-lft-tab-3" class="tab-pane fade">
                                                            <p class="text-main text-semibold">Third Tab Content</p>
                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                                                        </div>
                                                    </div> --}}


                                                    {{-- bener --}}
                                                    {{-- <ul class="nav nav-tabs">
                                                        @foreach ($dataKn as $kategori)
                                                            @foreach ($dataGp as $item)
                                                                @if ($item->sekolah && $item->sekolah->id_sekolah == $kategori->id_sekolah)
                                                                    <li>
                                                                        <a data-toggle="tab" href="#kategori-{{ $kategori->id_gp }}">{{ $kategori->kategori }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </ul> --}}
                                                    
                                                    
                                                    {{-- <div class="tab-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Nama Sekolah</th>
                                                                        <th>Nama Kelas</th>
                                                                        <th>Tahun Ajaran</th>
                                                                        <th>NIS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($dataKk as $item)
                                                                    <tr>
                                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                                        <td style="vertical-align: middle;">
                                                                            @if ($item->sekolah)
                                                                                {{ $item->sekolah->nama_sekolah }}
                                                                            @else
                                                                                Sekolah not assigned
                                                                            @endif
                                                                        </td>  
                                                                        <td style="vertical-align: middle;">
                                                                            @if ($item->kelas)
                                                                                {{ $item->kelas->nama_kelas }}
                                                                            @else
                                                                                Kelas not assigned
                                                                            @endif
                                                                        </td>       
                                                                        <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>     
                                                                        <td style="vertical-align: middle;">{{ $item->nis_siswa }}</td>
                                                                        <td class="table-action" style="vertical-align: middle;">
                                                                            <div style="display:flex; align-items:center">
                                                                                <a style="margin-right: 10px;" href="{{ route( 'kenaikanKelas.edit', $item->id_kk) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                            <form method="POST" action="" id="delete-form-{{ $item->id_kk }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <a href="/admin/kenaikanKelas/destroy/{{ $item->id_kk }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_kk }})">Hapus</a>				
                                                                            </form>	
                                                                            </div>													
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <script>
                                                                        function confirmDelete(menuId) {
                                                                            if (confirm('Are you sure you want to delete this item?')) {
                                                                                document.getElementById('delete-form-' + menuId).submit();
                                                                            }
                                                                        }
                                                                    </script>
                                                                     @if(session('success'))
                                                                     <div class="alert alert-info">
                                                                         {{ session('success') }}
                                                                     </div>
                                                                     @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        {{ $dataKk->links('pagination::bootstrap-4') }}
                                                    </div> --}}
                                                    {{-- bener --}}


                                                    {{-- <div class="tab-content">
                                                        @foreach ($dataKn as $kategori)
                                                            <div id="kategori-{{ $kategori->id_kn }}" class="tab-pane">
                                                                @foreach ($dataGp as $item)
                                                                    @if ($item->sekolah && $item->sekolah->id_sekolah == $kategori->id_sekolah)
                                                                        <!-- Tampilkan kategori nilai yang sesuai dengan sekolah -->
                                                                        {{ $kategori->nama_kategori }}
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div> --}}

                                                    <div class="container">
                                                        <ul class="nav nav-tabs" id="kategori-tabs">
                                                            @foreach ($dataKn as $key => $kategori)
                                                                @foreach ($dataGp as $item)
                                                                    @if ($item->sekolah && $item->sekolah->id_sekolah == $kategori->id_sekolah)
                                                                        <li class="{{ $key === 0 ? 'active' : '' }}">
                                                                            <a data-toggle="tab" href="#kategori-{{ $kategori->id_gp }}">{{ $kategori->kategori }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </ul>
                                                        {{-- <ul class="nav nav-tabs" id="kategori-tabs">
                                                            @foreach ($dataKn as $kategori)
                                                                <li>
                                                                    <a data-toggle="tab" href="#kategori-{{ $kategori->id }}">{{ $kategori->kategori }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul> --}}
                                                
                                                        <div class="tab-content">
                                                            @foreach ($dataKn as $key => $kategori)
                                                                <div id="kategori-{{ $kategori->id }}" class="tab-pane {{ $key === 0 ? 'active' : '' }}">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama Sekolah</th>
                                                                                    <th>Nama Kelas</th>
                                                                                    <th>Tahun Ajaran</th>
                                                                                    <th>NIS</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($dataKk as $item)
                                                                                <tr>
                                                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                                                    <td style="vertical-align: middle;">
                                                                                        @if ($item->sekolah)
                                                                                            {{ $item->sekolah->nama_sekolah }}
                                                                                        @else
                                                                                            Sekolah not assigned
                                                                                        @endif
                                                                                    </td>
                                                                                    <td style="vertical-align: middle;">
                                                                                        @if ($item->kelas)
                                                                                            {{ $item->kelas->nama_kelas }}
                                                                                        @else
                                                                                            Kelas not assigned
                                                                                        @endif
                                                                                    </td>
                                                                                    <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>
                                                                                    <td style="vertical-align: middle;">{{ $item->nis_siswa }}</td>
                                                                                    {{-- <td class="table-action" style="vertical-align: middle;">
                                                                                        <div style="display:flex; align-items:center">
                                                                                            <a style="margin-right: 10px;" href="{{ route( 'kenaikanKelas.edit', $item->id_kk) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                                            <form method="POST" action="" id="delete-form-{{ $item->id_kk }}">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <a href="/admin/kenaikanKelas/destroy/{{ $item->id_kk }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_kk }})">Hapus</a>
                                                                                            </form>
                                                                                        </div>
                                                                                    </td> --}}
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    {{ $dataKk->links('pagination::bootstrap-4') }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        $(document).ready(function () {
            $('#kategori-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active' ke tab pertama setelah halaman dimuat
            $('#kategori-tabs li:first-child').addClass('active');
        });
    </script>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection
