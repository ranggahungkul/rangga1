<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa;
use Illuminate\Support\Facades\Session;

class siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kataKunci = $request->katakunci;
        $jumlahBaris = 5;
        if (strlen($kataKunci)) {
            $data = siswa::where('nis', 'like', "%$kataKunci%")
                ->orWhere('nama', 'like', "%$kataKunci%")
                ->orWhere('jk', 'like', "%$kataKunci%")
                ->orWhere('ttl', 'like', "%$kataKunci%")
                ->orWhere('kelas', 'like', "%$kataKunci%")
                ->orWhere('jurusan', 'like', "%$kataKunci%")
                ->paginate($jumlahBaris);
        } else {
            $data = siswa::orderBy('nis', 'asc')->paginate(5);
        }
        return view('siswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Session::flash('nis', $request->nis);
        Session::flash('nama', $request->nama);
        Session::flash('jk', $request->jk);
        Session::flash('ttl', $request->ttl);
        Session::flash('kelas', $request->kelas);
        Session::flash('jurusan', $request->jurusan);
        $request->validate(
            [
                'nis' => 'required|numeric|unique:siswa,nis',
                'nama' => 'required',
                'jk' => 'required',
                'ttl' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
                'image' => 'image|mimes:jpg,jpeg,png',
            ],
            [
                'nis.required' => 'NIS harus diisi!',
                'nis.numeric' => 'NIS harus dalam angka!',
                'nis.unique' => 'NIS sudah ada!',
                'nama.required' => 'Nama harus diisi!',
                'jk.required' => 'Jenis Kelamin harus diisi!',
                'ttl.required' => 'Tempat Tanggal Lahir harus diisi!',
                'kelas.required' => 'Kelas harus diisi!',
                'jurusan.required' => 'Jurusan harus diisi!',
            ]
        );

        $newName = 'default.png';

        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->nis . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->move(public_path('gambar'), $newName);
            // $request->file('image')->storeAs('gambar', $newName);
        }


        $data = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'ttl' => $request->ttl,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'image' => $newName,
        ];

        // dd($data);

        siswa::create($data);
        return redirect()->to('siswa')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = siswa::where('nis', $id)->first();
        return view('siswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nis)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'ttl' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi!',
            'jk.required' => 'Jenis Kelamin harus diisi!',
            'ttl.required' => 'Tempat Tanggal Lahir harus diisi!',
            'kelas.required' => 'Kelas harus diisi!',
            'jurusan.required' => 'Jurusan harus diisi!'
        ]);
        $siswa = siswa::where('nis', $nis)->first();

        if ($request->file('image')) {
            if ($siswa->image != 'default.png') {
                unlink(public_path('gambar/') . $siswa->image);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $siswa->nis . '-' . now()->timestamp . '.' . $extension;

            $request->file('image')->move(public_path('gambar'), $newName);

            Siswa::where('nis', $nis)->update([
                'image' => $newName,
            ]);
        }


        $data = [
            'nama' => $request->nama,
            'jk' => $request->jk,
            'ttl' => $request->ttl,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ];

        Siswa::where('nis', $nis)->update($data);
        return redirect()->to('siswa')->with('success', 'Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::where('nis', $id);
        // dd($siswa->first()->image);
        if ($siswa->first()->image != 'default.png') {
            unlink(public_path('gambar/') . $siswa->first()->image);
        }
        $siswa->delete();
        return redirect()->to('siswa')->with('success', 'Data berhasil dihapus!');
    }
}
