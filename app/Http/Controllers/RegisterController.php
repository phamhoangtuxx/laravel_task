<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $params = $request->all();
        $validator = validator::make($params, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ],);

        $user = DB::table('users');
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors;
        } else {

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
            ]);
            $mailLable = new SendMail($user);
            $sendMail = Mail::to("phamhoangtuxx@gmail.com")->send($mailLable);
            return $user;
        }
        // return view('users.register');
    }
}
