<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\TwilioService;

class PasswordResetLinkController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Authentication/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|exists:users,username',
        ]);
    
        // Find the user by username
        $user = User::where('username', $request->username)->first();
    
        if (!$user) {
            return back()->withErrors(['username' => 'User not found.']);
        }else{
            $mobile = $user->profile->mobile;
        }
    
        // Generate a password reset token
        $token = Str::random(60);
    
        // Save the token in the password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->username], // Use 'username' as a key
            [
                'email' => $user->username,
                'token' => bcrypt($token),
                'created_at' => now(),
            ]
        );
    
        // Generate the reset link
        $resetLink = url('/reset-password?token=' . $token . '&username=' . $user->username);
    // dd($resetLink);
        // Send the reset link via SMS
        $this->twilio->sendSms($mobile, $resetLink);
    
        return back()->with('status', 'Password reset link sent via SMS.');
    }
}
