<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Les;
use Illuminate\Support\Facades\Redis;


class TutorController extends Controller
{
    
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->deskripsi = $request->deskripsi;
        $users->alamat = $request->alamat;
        $users->no_hp = $request->no_hp;
        $users->r_pendidikan = $request->r_pendidikan;
        $users->save();

        toast('Data telah tersimpan','success')->autoClose(3000);
        return redirect('pengaturan-tutor');
    }

    public function updatefoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image',
        ],
        [
            'foto.required' => 'Pilih foto!',
        ]);

        $foto = $request->file('foto');
        $newFoto = 'foto_tutor' . '_' . time() . '.' . $foto->extension();

        $path = 'tutor/img/';
        $request->foto->move(public_path($path), $newFoto);
        $users = User::find($id);
        $users->foto = $newFoto;
        $users->update();

        toast('Foto telah di update','success')->autoClose(3000);
        return redirect('pengaturan-tutor');
    }

    public function updateprofil(Request $request, $id)
    {
        $request->validate([
            "nama" => "required",
            "email" => "required",
        ],
        [
            "nama.required" => "Nama tidak boleh kosong",
            "email.required" => "Email tidak boleh kosong",
            "email.unique" => "Email sudah ada!",
        ]);

        $users = User::find($id);
            $users->nama = $request->nama;
            $users->email = $request->email;
        $users->update();

        toast('Data telah tersimpan','success')->autoClose(3000);
        return redirect("pengaturan-tutor");
    }

    public function updatepassword(Request $request, $id)
    {
        $users = User::find($id);
        $password = auth()->user()->password;
        $password_lama = request('password_lama');
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required',
            'password_konfirmasi' => 'same:password_baru'
        ],
        [
            'password_lama.required' => 'Password tidak boleh kosong',
            'password_baru.required' => 'Password baru tidak boleh kosong!',
            'password_konfirmasi.same' => 'Password baru dan konfirmasi password harus sama!'
        ]);
        if(Hash::check($password_lama, $password)){
        } else {
            return back()->withErrors(['password_lama'=>'Password tidak sesuai!']);
        }

        User::whereId(auth()->User()->id)->update([
            'password' => Hash::make($request->password_baru)
        ]);

        toast('Password telah diubah','success')->autoClose(3000);
        return redirect("pengaturan-tutor");
    }
}
