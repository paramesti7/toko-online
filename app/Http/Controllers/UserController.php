<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(10);

        return view('admin.page.user',[
            'name'  => "User Management",
            'title' => 'Admin User Management',
            'data'  => $data,
        ]);
    }

    public function addModalUser()
    {
        return view('admin.modal.modalUser', [
            'title' => 'Tambah Data User',
            'nik'   => date('Ymd') . rand(000, 999),
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = new User;
        $data->nik          = $request->nik;
        $data->name         = $request->nama;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat       = $request->alamat;
        $data->tlp          = $request->tlp;
        $data->role         = $request->role;
        $data->tglLahir     = $request->tglLahir;
        $data->is_active    = 1;
        $data->is_mamber    = 0;
        $data->is_admin     = 1;
        
        // sunah start
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        } else {
            $data->foto = 'default.png'; // siapkan default.png di folder public/storage/product
        }
        // sunah end
        
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('userManagement');
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        // $hasValue = Hash::make($data->password);
        return view(
            'admin.modal.editUser',
            [
                'title' => 'Edit data User',
                'data'  => $data,
                // 'pass'  => (string) $hasValue,
            ]
        )->render();
    }
    public function update(UserRequest $request, $id)
    {
        $data = User::findOrFail($id);

        // Handle upload foto
        if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            // $data->foto = $filename;
        } else {
            $filename = $data->foto;
        }

        // FIELD UPDATE (LETTAKKAN DI SINI)
        $field = [
            'nik'                   => $request->nik,
            'name'                  => $request->nama,
            'email'                 => $request->email,
            'alamat'                => $request->alamat,
            'tlp'                   => $request->tlp,
            'tglLahir'              => $request->tglLahir,
            'role'                  => $request->role ?? $data->role,
            'foto'                  => $filename,
        ];

        // Password hanya diupdate jika diisi
        if ($request->filled('password')) {
            $field['password'] = bcrypt($request->password);
        }

        // Proses update ke database
        User::where('id', $id)->update($field);

        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->route('userManagement');
    }

    public function destroy($id)
    {
        $product = User::findOrFail($id);
        $product->delete();

        $json = [
            'success' => "Data berhasil dihapus"
        ];

        echo json_encode($json);
    }

    public function storePelanggan(UserRequest $request)
    {
        $data = new User;
        $nik  = "Member" . rand(000, 999);
        $data->nik          = $nik;
        $data->name         = $request->nama;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat = $request->alamat;
        if ($request->filled('alamat2')) {
            $data->alamat .= ' ' . $request->alamat2;
        }
        $data->tlp          = $request->tlp;
        $data->role         = 0;
        $data->tglLahir     = $request->date;
        $data->is_active    = 1;
        $data->is_mamber    = 1;
        $data->is_admin     = 0;

        // dd($request);die;

        if ($request->hasFile('foto') == "") {
            $filename = "default.png";
            $data->foto = $filename;
        } else {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('home');
    }

    public function loginProses(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

         // Data login
        $dataLogin = [
            'email' => $request->email,
            'password'  => $request->password,
        ];

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika email tidak ditemukan
        if (!$user) {
            Alert::toast('Email tidak terdaftar', 'error');
            return back()->withInput();
        }

        // Jika akun tidak aktif
        if ($user->is_active == 0) {
            Alert::toast('Akun belum aktif', 'error');
            return back()->withInput();
        }

        // PROSES LOGIN
        if (Auth::attempt($dataLogin)) {
            $request->session()->regenerate();

            Alert::toast('Login berhasil', 'success');

            // Redirect ke HOME pelanggan
            return redirect()->route('home');
        }

        // Jika password salah
        Alert::toast('Email atau Password salah', 'error');
        return back()->withInput();

        // $user = new User;
        // $proses = $user::where('email', $request->email)->first();

        // if ($proses->is_active === 0) {
        //     Alert::toast('Kamu belum register', 'error');
        //     return back();
        // }
        // if (Auth::attempt($dataLogin)) {
        //     Alert::toast('Kamu berhasil login', 'success');
        //     $request->session()->regenerate();
        //     return redirect()->intended('/');
        // } else {
        //     Alert::toast('Email dan Password salah', 'error');
        //     return back();
        // }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('/');
    }
}
