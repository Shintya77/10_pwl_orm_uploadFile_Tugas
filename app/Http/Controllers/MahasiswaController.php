<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa'=> $mahasiswa, 'paginate'=>$paginate]);

    }

    public function search(Request $request){
        //menangkap data pencarian
        $cari = $request->search;

        //mengambil data dari table Mahasiswa sesuai pencarian data
        $paginate = Mahasiswa::where('Nama','like',"%".$cari."%")->paginate();

        //mengiriim data mahasiswa ke view index
        return view('mahasiswa.index', compact('paginate'));
    }


    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas'=>$kelas]);
        // return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Foto' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required',
            ]);

            if ($request->file('Foto')){
                $image_name = $request->file('Foto')->store('Foto', 'public');
            }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->Nim = $request->get('Nim');
        $mahasiswa->Nama = $request->get('Nama');
        $mahasiswa->Foto = $image_name;
        $mahasiswa->Jurusan= $request->get('Jurusan');
        $mahasiswa->No_Handphone= $request->get('No_Handphone');
        $mahasiswa->Email= $request->get('Email');
        $mahasiswa->Alamat= $request->get('Alamat');
        $mahasiswa->TanggalLahir= $request->get('TanggalLahir');

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
   
    }
    
    public function show($Nim)
    {
         $mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
         return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);;
    }

    public function edit($Nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari table kelas)
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
        
    }

    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Foto' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required',
        ]);
        
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $Mahasiswa->Nim = $request->get('Nim');
        $Mahasiswa->Nama = $request->get('Nama');
        $Mahasiswa->Foto = $request->get('Foto');
        $Mahasiswa->Jurusan= $request->get('Jurusan');
        $Mahasiswa->No_Handphone= $request->get('No_Handphone');
        $Mahasiswa->Email= $request->get('Email');
        $Mahasiswa->Alamat= $request->get('Alamat');
        $Mahasiswa->TanggalLahir= $request->get('TanggalLahir');
        $Mahasiswa->save();

        if ($Mahasiswa->Foto && file_exists(storage_path('app/public/'.$Mahasiswa->Foto))){
            \Storage::delete('public/'. $article->featured_image);
        }
        $image_name = $request->file('Foto')->store('Foto', 'public');
        $Mahasiswa->Foto = $image_name;

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $Mahasiswa->kelas()->associate($kelas);
        $Mahasiswa->save();
    
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
   
    }

    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($Nim){
        $nilai = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        return view('mahasiswa.nilai', compact('nilai'));
    }

    public function cetak_pdf($Nim){
        $nilai = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        $pdf = PDF::loadview('mahasiswa.cetakNilai',compact('nilai'));
        return $pdf->stream();
    }
}
