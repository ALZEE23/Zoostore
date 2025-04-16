<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // Default data untuk user
        $defaultUser = [
            'name'            => 'Guest',
            'email'           => 'guest@example.com',
            'phone'           => '',
            'profile_picture' => null,
            'address'         => '',
            'gender'          => '',
            'birthdate'       => '',
            'district'        => '',
            'city'            => '',
            'province'        => '',
            'postal_code'     => '',
        ];

        // Ambil data user dari session, lalu gabungkan dengan defaultUser
        $user = array_merge($defaultUser, Session::get('user', []));

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Default data untuk user
        $defaultUser = [
            'name'            => 'Guest',
            'email'           => 'guest@example.com',
            'phone'           => '',
            'profile_picture' => null,
            'address'         => '',
            'gender'          => '',
            'birthdate'       => '',
            'district'        => '',
            'city'            => '',
            'province'        => '',
            'postal_code'     => '',
        ];

        // Ambil data user dari session dan gabungkan dengan default
        $user = array_merge($defaultUser, Session::get('user', []));

        // Validasi data yang masuk, termasuk field informasi pribadi
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:20',
            'password'        => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|max:2048',
            'remove_photo'    => 'nullable|in:0,1',
            // Field tambahan
            'address'         => 'nullable|string',
            'gender'          => 'nullable|in:Laki-laki,Perempuan',
            'birthdate'       => 'nullable|date',
            'district'        => 'nullable|string',
            'city'            => 'nullable|string',
            'province'        => 'nullable|string',
            'postal_code'     => 'nullable|string',
        ]);

        // Jika remove_photo bernilai 1, hapus foto lama jika ada
        if (!empty($data['remove_photo']) && $data['remove_photo'] === '1') {
            if (!empty($user['profile_picture'])) {
                Storage::disk('public')->delete($user['profile_picture']);
            }
            $user['profile_picture'] = null;
        }

        // Tangani file baru (foto profil)
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if (!empty($user['profile_picture'])) {
                Storage::disk('public')->delete($user['profile_picture']);
            }
            // Simpan file baru ke folder profile_pictures pada disk public
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user['profile_picture'] = $path;
        }

        // Update data user
        $user['name']         = $data['name'];
        $user['email']        = $data['email'];
        $user['phone']        = $data['phone'] ?? '';
        $user['address']      = $data['address'] ?? '';
        $user['gender']       = $data['gender'] ?? '';
        $user['birthdate']    = $data['birthdate'] ?? '';
        $user['district']     = $data['district'] ?? '';
        $user['city']         = $data['city'] ?? '';
        $user['province']     = $data['province'] ?? '';
        $user['postal_code']  = $data['postal_code'] ?? '';

        if (!empty($data['password'])) {
            $user['password'] = bcrypt($data['password']);
        }

        // Simpan data ke session
        Session::put('user', $user);

        return back()->with('success', 'Profile berhasil di-update!');
    }

    public function destroy(Request $request)
    {
        Session::forget('user');
        return redirect('/')->with('success', 'Akun dihapus (dari session aja hehe)');
    }

    public function dataPribadi()
    {
        $defaultUser = [
            'name'            => 'Guest',
            'email'           => 'guest@example.com',
            'phone'           => '',
            'profile_picture' => null,
            'address'         => '',
            'gender'          => '',
            'birthdate'       => '',
            'district'        => '',
            'city'            => '',
            'province'        => '',
            'postal_code'     => '',
        ];
        $user = array_merge($defaultUser, Session::get('user', []));
        return view('profile.datapribadi', compact('user'));
    }
}
