<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {   
        return Inertia::render('Authentication/ResetPassword', [
            'username' => $request->query('username'),
            'token' => $request->query('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'username' => 'required|exists:users,username',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        // $status = Password::reset(
        //     $request->only('username', 'password', 'password_confirmation', 'token'),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => Hash::make($request->password),
        //             'remember_token' => Str::random(60),
        //         ])->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // if ($status == Password::PASSWORD_RESET) {
        //     return redirect()->route('login')->with('status', __($status));
        // }

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
        $user = DB::table('users')->where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Invalid username.']);
        }
        $resetEntry = DB::table('password_reset_tokens')
        ->where('email', $user->username) // Assuming 'email' column is reused for 'username'
        ->first();

    if (!$resetEntry || !Hash::check($request->token, $resetEntry->token)) {
        return back()->withErrors(['token' => 'Invalid or expired token.']);
    }


    // Update the user's password
    DB::table('users')->where('id', $user->id)->update([
        'password' => Hash::make($request->password),
        'remember_token' => Str::random(60),
    ]);

    // Fire the password reset event
    event(new PasswordReset($user));

    // Delete the reset token entry
    DB::table('password_reset_tokens')
        ->where('email', $user->username)
        ->delete();

    return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
