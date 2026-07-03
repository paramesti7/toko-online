<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function index()
    {
        $data = User::where('is_admin', 1)->paginate(10);

        return view('admin.page.user',[
            'name'  => "User Management",
            'title' => 'Admin User Management',
            'data'  => $data,
        ]);
    }

    public function pelanggan()
    {
        $data = User::where('is_admin', 0)->paginate(10);

        return view('admin.page.pelanggan', [
            'name'  => 'User Pelanggan',
            'title' => 'Data Pelanggan',
            'data'  => $data
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
        $data->role         = $request->role;
        $data->is_active    = 1;
        $data->is_mamber    = 0;
        $data->is_admin     = 1;
        
        // sunah start
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->storeAs('user', $filename, 'public');
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
        
        return view(
            'admin.modal.editUser',
            [
                'title' => 'Edit data User',
                'data'  => $data,
                
            ]
        )->render();
    }

    public function update(UserRequest $request, $id)
    {
        $data = User::findOrFail($id);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->storeAs('user', $filename, 'public');
        } else {
            $filename = $data->foto;
        }

        // FIELD UPDATE (LETTAKKAN DI SINI)
        $field = [
            'nik'                   => $request->nik,
            'name'                  => $request->nama,
            'email'                 => $request->email,
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
        $data->role         = 0;
        $data->is_active    = 1;
        $data->is_mamber    = 1;
        $data->is_admin     = 0;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->storeAs('user', $filename, 'public');
            $data->foto = $filename;
        } else {
            $data->foto = 'default.png';
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
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        $user = User::where('email', $request->email)->where('is_admin', 0)->first();

        if (!$user) {
            Alert::toast('Email dan Password Salah', 'error');
            return back()->withInput();
        }

        if ($user->is_active == 0) {
            Alert::toast('Akun belum aktif', 'error');
            return back()->withInput();
        }

         // Data login
        $dataLogin = [
            'email' => $request->email,
            'password'  => $request->password,
        ];

        // PROSES LOGIN
        if (Auth::guard('web')->attempt($dataLogin)) {
            $request->session()->regenerate();

            Alert::toast('Login berhasil', 'success');

            // Redirect ke HOME pelanggan
            return redirect()->route('home');
        }
        

        // Jika password salah
        return back()
            ->withErrors([
                'login' => 'Email atau password Anda salah.'
            ])
            ->withInput();

    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Anda berhasil Logout', 'success');
        return redirect('/');
    }
}
