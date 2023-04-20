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
    public function index(Request $request)
    {
        $user = Auth::User();
        $tutor = Auth::User()->id;
        $users = User::where("role","tutor");

        return view ('tutor.pengaturan', compact('users'))->with(["user" => $user]);
    }

    // public function home()
    // {
    //     $user = Auth::User();
    //     $tutor = Auth::user()->id;
    //     $users = User::where("role","tutor")->paginate();
    //     return view('tutor.layout.home', compact('users'))->with([ "user" => $user]);  
    // }
    public function home()
    {
        $user = Auth::User();
        $tutormtk = Mapel::where("mapel", "=", "Matematika")->count();
        $tutoringgris = Mapel::where("mapel", "=", "Bahasa Inggris")->count();
        $tutoripa = Mapel::where("mapel", "=", "IPA")->count();
        $tutorindo = Mapel::where("mapel", "=", "Bahasa Indonesia")->count();
        return view('tutor.layout.home', compact("tutormtk","tutoringgris","tutoripa","tutorindo"))->with(["user" => $user]);
    }
    // public function home()
    // {
    //     $user = Auth::User();
    //     $id = Auth::User()->id;
    //     $tutor = User::join('mapel','mapel.id_tutor','=','users.id')
    //     ->select('users.id','users.nama','users.foto','users.deskripsi','users.alamat','users.pendidikan','users.no_hp')->
    //     where('mapel.id_tutor','=',$id);
    //     $mapel = Mapel::all();
    //     return view('tutor.layout.home', compact('user','tutor','mapel'));  
    // }

    public function mtk(Request $request)
    {
        $user = Auth::User();
        $keyword = $request->keyword;
        $mapel = DB::table("mapel")
        ->leftjoin("users","users.id","=","mapel.id_tutor")
        // ->where("mapel.id_tutor",$id)
        ->where("mapel.mapel","=","Matematika")
        ->select(
            "users.foto",
            "users.nama",
            "users.deskripsi",
            "users.alamat",
            "users.r_pendidikan",
            "users.no_hp",
            "mapel.id_tutor",
            "mapel.pendidikan",
            "mapel.slot",
            "mapel.jadwal",
            "mapel.harga",          
        )->paginate();
        return view('tutor.tutormtk', compact('mapel'))->with([ "user" => $user]);
    }

    public function detailmurid()
    {
        $user = Auth::User();

        return view('tutor.detailmurid')->with([ "user" => $user]);  
    }

    public function detailmuridpending()
    {
        $user = Auth::User();

        return view('tutor.detailmuridpending')->with([ "user" => $user]);  
    }

    public function rps()
    {
        $user = Auth::User();

        return view('tutor.rps')->with([ "user" => $user]);  
    }

    public function dokumen()
    {
        $user = Auth::User();

        return view('tutor.dokumen')->with([ "user" => $user]);  
    }

    public function daftarmurid()
    {
        $user = Auth::User();

        return view('tutor.daftarmurid')->with([ "user" => $user]);  
    }

    public function pending()
    {
        $user = Auth::User();

        return view('tutor.pending')->with([ "user" => $user]);  
    }


    public function create()
    {
        $user = Auth::User();
        return view('tutor.profil')->with([
            "user" => $user,
        ]);
    }

    public function destroy($id, Request $request)
    {
        $users = User::find($id);
        $users->delete();

        return redirect("/");
    }

    // public function store($id, Request $request)
    // {
    //     $user = User::find($id);
    //     $validated = $request->validate([
    //         'foto'      => 'required|mimes:jpg,png,jpeg',
    //         'mapel'     => 'required',
    //     ],
    //     [
    //         'mapel.required' => 'Silahkan pilih mata pelajaran',
    //     ]);

    //     $newFoto = '';
    //     if($request->hasFile('foto'))
    //     {
    //         $foto = $request->file('foto');
    //         $foto_ext = $foto->getClientOriginalExtension();
    //         $newFoto = 'foto_tutor' . '.' . $foto_ext;

    //         $pathFoto = 'tutor/img/';
    //         $foto->move(public_path($pathFoto), $newFoto);
    //     }
    //     $user->foto       = $newFoto;
    //     $user->deskripsi  = $request->deskripsi;
    //     $user->mapel      = $request->mapel;
    //     $user->alamat     = $request->alamat;
    //     $user->no_hp      = $request->no_hp;
    //     $user->pendidikan = $request->pendidikan;
    //     $user->save();

    //     return redirect('pengaturan-tutor');
    // }

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
