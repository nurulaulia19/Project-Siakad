<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataNilai;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\KategoriNilai;
use App\Models\KenaikanKelas;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\GuruPelajaranJadwal;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

class GuruPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','guruMapelJadwal')->orderBy('id_gp', 'DESC')->paginate(10);

        // menu
        $user_id = auth()->user()->user_id;
        $user = DataUser::findOrFail($user_id);
        $menu_ids = $user->role->roleMenus->pluck('menu_id');

        $menu_route_name = request()->route()->getName(); // Nama route dari URL yang diminta

        // Ambil menu berdasarkan menu_link yang sesuai dengan nama route
        $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        // dd($requested_menu);

        // Periksa izin akses berdasarkan menu_id dan user_id
        if (!$requested_menu || !$menu_ids->contains($requested_menu->menu_id)) {
            return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        }

        $mainMenus = Data_Menu::where('menu_category', 'master menu')
            ->whereIn('menu_id', $menu_ids)
            ->get();

        $menuItemsWithSubmenus = [];

        foreach ($mainMenus as $mainMenu) {
            $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                ->where('menu_category', 'sub menu')
                ->whereIn('menu_id', $menu_ids)
                ->orderBy('menu_position')
                ->get();

            $menuItemsWithSubmenus[] = [
                'mainMenu' => $mainMenu,
                'subMenus' => $subMenus,
            ];
            
    }
    return view('guruMapel.index', compact('dataGp','menuItemsWithSubmenus'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataGp = GuruPelajaran::all();
        $dataPelajaran = DataPelajaran::all();
        // $dataUser = DataUser::all();
        $guruRoleId = Role::where('role_name', 'guru')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($guruRoleId) {
            $query->where('role_id', $guruRoleId);
        })->get();

        $dataSekolah = Sekolah::all();
        $dataKelas = Kelas::all();

        // MENU
        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'

            $user = DataUser::find($user_id);
            $role_id = $user->role_id;

            $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');

            $mainMenus = Data_Menu::where('menu_category', 'master menu')
                ->whereIn('menu_id', $menu_ids)
                ->get();

            $menuItemsWithSubmenus = [];

            foreach ($mainMenus as $mainMenu) {
                $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                    ->where('menu_category', 'sub menu')
                    ->whereIn('menu_id', $menu_ids)
                    ->orderBy('menu_position')
                    ->get();

                $menuItemsWithSubmenus[] = [
                    'mainMenu' => $mainMenu,
                    'subMenus' => $subMenus,
                ];
            }
        return view('guruMapel.create', compact('dataGp','dataUser','dataPelajaran','dataKelas','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.'
            // Add other custom error messages as needed
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_guru_pelajaran')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_pelajaran', $request->id_pelajaran)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'id_kelas' => 'required',
            'tahun_ajaran' => 'required',
        ], $customMessages);
        
        $dataGp = new GuruPelajaran;
        $dataGp->id_sekolah = $request->id_sekolah;
        $dataGp->id_pelajaran = $request->id_pelajaran;
        $dataGp->id_kelas = $request->id_kelas;
        $dataGp->user_id = $request->user_id;
        $dataGp->tahun_ajaran = $request->tahun_ajaran;
        $dataGp->save();
        

        return redirect()->route('guruMapel.index')->with('success', 'Guru Mata Pelajaran insert successfully');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_gp)
    {
        
        $dataSekolah = Sekolah::all();
       
        $guruRoleId = Role::where('role_name', 'guru')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($guruRoleId) {
            $query->where('role_id', $guruRoleId);
        })->get();
        $selectedMapelId = GuruPelajaran::where('id_gp', $id_gp)->pluck('id_pelajaran')->toArray();
        // $selectedMapelId = PelajaranKelas::where('id_pk', $id_pk)->first()->id_pelajaran;
        $dataGp = GuruPelajaran::where('id_gp', $id_gp)->first();
        $dataPelajaran = DataPelajaran::where('id_sekolah', $dataGp->id_sekolah)->get();
        $dataKelas = Kelas::where('id_sekolah', $dataGp->id_sekolah)->get();
        
    
        // MENU
        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
    
                $user = DataUser::find($user_id);
                $role_id = $user->role_id;
    
                $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
    
                $mainMenus = Data_Menu::where('menu_category', 'master menu')
                    ->whereIn('menu_id', $menu_ids)
                    ->get();
    
                $menuItemsWithSubmenus = [];
    
                foreach ($mainMenus as $mainMenu) {
                    $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                        ->where('menu_category', 'sub menu')
                        ->whereIn('menu_id', $menu_ids)
                        ->orderBy('menu_position')
                        ->get();
    
                    $menuItemsWithSubmenus[] = [
                        'mainMenu' => $mainMenu,
                        'subMenus' => $subMenus,
                    ];
                }
        return view('guruMapel.update', compact('dataGp','dataSekolah','dataKelas','dataUser','dataPelajaran','menuItemsWithSubmenus','selectedMapelId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_gp)
    {
        
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.'
            // Add other custom error messages as needed
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_guru_pelajaran')->ignore($id_gp, 'id_gp')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_pelajaran', $request->id_pelajaran)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'id_kelas' => 'required',
            'tahun_ajaran' => 'required',
        ], $customMessages);

        DB::table('data_guru_pelajaran')->where('id_gp', $id_gp)->update([
            'id_kelas' => $request->id_kelas,
            'id_pelajaran' => $request->id_pelajaran,
            'user_id' => $request->user_id,
            'id_sekolah' => $request->id_sekolah,
            'tahun_ajaran' => $request->tahun_ajaran,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('guruMapel.index')->with('success', 'Guru Mata Pelajaran edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_gp){
        $dataGp = GuruPelajaran::where('id_gp', $id_gp);
        $dataGp->delete();
        $dataGpj = GuruPelajaranJadwal::where('id_gp', $id_gp);
        $dataGpj->delete();
        return redirect()->route('guruMapel.index')->with('success', 'Terdelet');
    }

    public function getKelas(Request $request){
        $kelas = Kelas::where('id_sekolah', $request->sekolahID)->pluck('id_kelas', 'nama_kelas');
        return response()->json($kelas);
    }

    public function getMapel(Request $request){
        $mapel = DataPelajaran::where('id_sekolah', $request->sekolahID)->pluck('id_pelajaran', 'nama_pelajaran');
        return response()->json($mapel);
    }

    public function nilai() {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel')->orderBy('id_gp', 'DESC')->paginate(10);

        // MENU
        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
    
                $user = DataUser::find($user_id);
                $role_id = $user->role_id;
    
                $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
    
                $mainMenus = Data_Menu::where('menu_category', 'master menu')
                    ->whereIn('menu_id', $menu_ids)
                    ->get();
    
                $menuItemsWithSubmenus = [];
    
                foreach ($mainMenus as $mainMenu) {
                    $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                        ->where('menu_category', 'sub menu')
                        ->whereIn('menu_id', $menu_ids)
                        ->orderBy('menu_position')
                        ->get();
    
                    $menuItemsWithSubmenus[] = [
                        'mainMenu' => $mainMenu,
                        'subMenus' => $subMenus,
                    ];
                }
    return view('dataNilai.nilai', compact('dataGp','menuItemsWithSubmenus'));
    }


    public function detailNilai(Request $request, $id_gp) {
        // $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel')->orderBy('id_gp', 'DESC')->paginate(10);
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
        $dataKn = KategoriNilai::all();

        $dataSekolah = Sekolah::all();

        $id_nilai = 13;
        $dataNilai = DataNilai::where('id_nilai', $id_nilai)->first();
        // $dataNilai = DataNilai::select('nilai', $id_gp)->first();
        // dd($dataNilai);
        $tab = $request->query('tab');
        

        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                ->where('data_guru_pelajaran.id_gp', $id_gp)
                ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    // 'data_kenaikan_kelas.id_sekolah',
                    // 'data_kenaikan_kelas.id_kelas',
                    // 'data_kenaikan_kelas.tahun_ajaran',
                    'data_kenaikan_kelas.id_kk', // Kolom id_kk
                    'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
                )
                ->with('siswa') 
                ->paginate(10);
                // dd($dataKk);
        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }
        
        
        // dd($id_gp);
        // MENU
        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
    
                $user = DataUser::find($user_id);
                $role_id = $user->role_id;
    
                $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
    
                $mainMenus = Data_Menu::where('menu_category', 'master menu')
                    ->whereIn('menu_id', $menu_ids)
                    ->get();
    
                $menuItemsWithSubmenus = [];
    
                foreach ($mainMenus as $mainMenu) {
                    $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                        ->where('menu_category', 'sub menu')
                        ->whereIn('menu_id', $menu_ids)
                        ->orderBy('menu_position')
                        ->get();
    
                    $menuItemsWithSubmenus[] = [
                        'mainMenu' => $mainMenu,
                        'subMenus' => $subMenus,
                    ];
                }

        return view('dataNilai.detail', compact('dataGp','menuItemsWithSubmenus','dataKn','dataKk','dataNilai','tab','id_gp'));
    }

    public function storeNilai(Request $request)
    {
        $nis_siswa = $request->input('nis_siswa');
        $nilai = $request->input('nilai');
        $id_gp = $request->input('id_gp');
        $kategori = $request->input('kategori');

        // Hapus data yang sudah ada dengan kriteria yang sama
        DataNilai::where('id_gp', $id_gp)
            ->where('kategori', $kategori)
            ->whereIn('nis_siswa', $nis_siswa)
            ->delete();

        // Simpan data baru
        foreach ($nis_siswa as $key => $nis) {
            $dataNilai = new DataNilai;
            $dataNilai->id_gp = $id_gp;
            $dataNilai->kategori = $kategori;
            $dataNilai->nis_siswa = $nis;
            $dataNilai->nilai = $nilai[$key];
            $dataNilai->save();
        }

        return redirect()->route('dataNilai.detail', ['id_gp' => $id_gp, 'tab'=> $kategori
        ])->with('success', 'Nilai insert successfully');
    }


    public static function getNilai ($id_gp, $kategori, $nis_siswa) {
        // $id_nilai = 13;
        $dataNilai = DataNilai::where('id_gp', $id_gp)
        ->where('kategori', $kategori)
        ->where('nis_siswa', $nis_siswa)->first();

        return @$dataNilai->nilai;
    }


    public function exportToPDF(Request $request, $id_gp)
    {
        $dataKk = KenaikanKelas::all();
        $dataKn = KategoriNilai::all();
        $tab = $request->query('tab');
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
        $paperSize = $request->input('paper_size', 'A4');

        // $dataNilai = $query->get();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Set ukuran kertas sesuai dengan parameter yang diambil dari request
        $pdfOptions->set('size', $paperSize);

        $pdf = new Dompdf($pdfOptions);

        // Render the view with data and get the HTML content
        $htmlContent = View::make('dataNilai.eksportNilai', compact('dataKk','dataGp','dataKn','tab'))->render();

        $pdf->loadHtml($htmlContent);

        $pdf->setPaper($paperSize, 'portrait'); // Atur ukuran kertas secara dinamis

        $pdf->render();

        return $pdf->stream('data-nilai.pdf');
    }
}
