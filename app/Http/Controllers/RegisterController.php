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
            return response()->json([
                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                ]),
                // Mail::to($request->email)->send(new SendMail($user))
            ]);
            $mailLable = new SendMail($user);
            Mail::to("phamhoangtuxx@gmail.com")->send($mailLable);
            return true;
        }
        // return view('users.register');
    }
}
