<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; 
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $profil=User::all();
        return view('tables',compact('user'));
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        // Cek apakah pengguna ingin mengubah email
        if ($request->has('email') && $user->email !== $request->input('email')) {
            $validatedData['email'] = $request->input('email');
            $user->email_verified_at = null; // Reset email_verified_at jika email berubah
        }
    
        // Cek apakah pengguna ingin mengubah foto profil
        if ($request->hasFile('profil_pic')) {
            // Validasi dan simpan file foto
            $request->validate([
                'profil_pic' => 'image|mimes:jpeg,png,jpg,gif|max:20480', // ukuran max 20MB
            ]);
    
            // Hapus foto lama jika ada
            if ($user->profil_pic) {
                Storage::delete('public/' . $user->profil_pic);
            }
    
            // Simpan foto baru dan ambil nama file
            $fileName = $request->file('profil_pic')->store('profile_pics', 'public');
            $validatedData['profil_pic'] = $fileName;
        }
    
        // Hanya update data yang ada dalam $validatedData
        if (!empty($validatedData)) {
            $user->fill($validatedData);
            $user->save();
        }
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    

    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
