<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        // Validasi input email
        $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        // Mengirim link reset password
        $status = Password::sendResetLink($request->only('email'));
    
        // Log status pengiriman link reset
        Log::info('Password reset link status: ' . $status);
    
        if ($status == Password::RESET_LINK_SENT) {
            Log::info('Reset link sent to: ' . $request->email);
            // Mengembalikan respons JSON sukses
            return response()->json(['success' => true, 'message' => __('A reset link has been sent to your email.')]);
        } else {
            Log::error('Failed to send reset link for email: ' . $request->email);
            // Mengembalikan respons JSON gagal
            return response()->json(['success' => false, 'message' => __($status)], 400);
        }
    }        
}
