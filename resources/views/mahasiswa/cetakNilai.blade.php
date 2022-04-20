@extends('mahasiswa.layout')
@section('content')
    <div class="row">
        <div class="col-12 text-center">
            <h3>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h3>
        </div>
        <div class="col-12 text-center">
            <h4><strong>KARTU HASIL STUDI (KHS)</strong></h4>
        </div>
        <div class="col-12 my-4">
            <p class="m-0"><strong>Nama:</strong> {{ $nilai->Nama }}</p>
            <p class="m-0"><strong>NIM:</strong> {{ $nilai->Nim }}</p>
            <p class="m-0"><strong>Kelas:</strong> {{ $nilai->kelas->nama_kelas }}</p>
            
        </div>
        <div class="col-12">
            <table class="table table-bordered">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                </tr>
                @foreach ($nilai->matakuliah as $nilai)
                    <tr>
                        <td>{{$nilai->nama_matkul}}</td>
                        <td>{{$nilai->sks}}</td>
                        <td>{{$nilai->semester}}</td>
                        <td>{{$nilai->pivot->nilai}}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </ul>
</div>
@endsection