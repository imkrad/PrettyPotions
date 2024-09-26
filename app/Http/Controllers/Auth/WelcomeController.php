<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\WelcomeNotification\WelcomeController as BaseWelcomeController;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends BaseWelcomeController
{
    public function sendPasswordSavedResponse(): Response
    {   
        User::where('id',Auth::user()->id)->update(['is_active'=>1]);
        return redirect('/home');
    }

    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:8'
        ];
    }
}
