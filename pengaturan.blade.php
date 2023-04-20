@extends('tutor.layout.main', ['title'=>'Pengaturan Profil'])

@section('judul')
    <div class="pagetitle">
        <h1>Profil Saya</h1>
    </div>
@endsection

@section('isi')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ asset ('tutor/img/'.$user->foto) }}" style="border-radius: 100%">
                        <h2>{{ $user->nama }}</h2><br>
                        <div class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{ $user->id }}"><i class="bi bi-exclamation-circle"></i> Hapus Akun</button>
                            <div class="modal fade" id="hapus{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Perhatian!!</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">Apakah Anda yakin ingin hapus akun?</div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tidak</button>
                                    <a href="delete/akun/tutor/{{ $user->id }}"><button type="button" class="btn btn-danger btn-sm">Hapus</button></a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Detail</button>
                            </li>             
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Detail Profil</button>
                            </li>            
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#change-photo-profile">Ubah Foto</button>
                            </li>            
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Profil</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#change-password">Ubah Password</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Deskripsi</h5>
                                <p class="small fst">{{ $user->deskripsi }}</p>
                                <h5 class="card-title">Detail Profil</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nama</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->nama }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->alamat }}</div>
                                </div>                   
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">No Handphone</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->no_hp }}</div>
                                </div>                  
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pendidikan</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->r_pendidikan }}</div>
                                </div>                  
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form action="update/detail/tutor/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="row mb-3">
                                            <label for="deskripsi" class="col-md-4 col-lg-3 col-form-label">Deskripsi</label>
                                            <div class="col-md-8 col-lg-9">
                                              <textarea type="text" name="deskripsi" class="form-control" id="deskripsi" rows="3">{{ $user->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                            <div class="col-md-8 col-lg-9">
                                              <input name="alamat" type="text" class="form-control" id="alamat" value="{{ $user->alamat }}">
                                            </div>
                                        </div>               
                                        <div class="row mb-3">
                                            <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">No Handphone</label>
                                            <div class="col-md-8 col-lg-9">
                                              <input name="no_hp" type="text" class="form-control" id="no_hp" value="{{ $user->no_hp }}">
                                            </div>
                                        </div>                     
                                        <div class="row mb-3">
                                            <label for="r_pendidikan" class="col-md-4 col-lg-3 col-form-label">Pendidikan</label>
                                            <div class="col-md-8 col-lg-9">
                                              <input name="r_pendidikan" type="text" class="form-control" id="r_pendidikan" value="{{ $user->r_pendidikan }}">
                                            </div>
                                        </div>                     
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm">Ubah Details</button>
                                        </div>                   
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="change-photo-profile">
                                <form action="update/foto/tutor/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="foto" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                                        <div class="col-sm-7 @error('foto') is-invalid @enderror">
                                            <input class="form-control" type="file" name="foto" id="foto">
                                        </div>
                                        @error('foto')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm">Ubah Foto</button>
                                        </div> 
                                </form>
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form action="update/profil/tutor/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="form-group">
                                            <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" class="form-control
                                                @error('nama')
                                                is-invalid
                                                @enderror"
                                                name="nama" id="nama" value="{{ $user->nama }}">
                                                @error('nama')
                                                    <div class='invalid-feedback'>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" class="form-control
                                                @error('email')
                                                is-invalid
                                                @enderror"
                                                name="email" id="email" value="{{ $user->email }}">
                                                @error('email')
                                                    <div class='invalid-feedback'>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>                
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-sm">Ubah Profil</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade pt-3" id="change-password">
                                <form action="update/password/tutor/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" name="password_lama" id="password_lama" class="form-control
                                            @error('password_lama')
                                            is-invalid
                                            @enderror
                                            " placeholder="Masukan Password Lama">
                                            @error('password_lama')
                                                <div class='invalid-feedback'>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" name="password_baru" id="password_baru" class="form-control
                                            @error('password_baru')
                                            is-invalid
                                            @enderror
                                            " placeholder="Masukan Password Baru">
                                            @error('password_baru')
                                                <div class='invalid-feedback'>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Ubah Password</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
