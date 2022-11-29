<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendMail;
use App\Mail\SendRecoveryCode;
use Illuminate\Support\Facades\Mail;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{



    //register
    public function register(Request $request)
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
            $length = 7;
            $pool = '0123456789349487324987384973895735632984601937497383748374385610';
            $VerifiedCode = substr(str_shuffle(str_repeat($pool, 4)), 0, $length);


            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'VerifiedCode' => $request['VerifiedCode'],
                'VerifiedCode' =>   $VerifiedCode,
            ]);
            $mailLable = new SendMail($user);
            $sendMail = Mail::to("phamhoangtuxx@gmail.com")->send($mailLable);
            return $user;
        }
        // return view('users.register');
    }
    //lohin
    public function store(Request $request)
    {
        $email     = $request->get('email', '');
        $password  = $request->get('password', '');
        $params    = $request->all();

        $validator = validator::make($params, [
            'email' => ['required', 'string', 'email', 'max:255',],
            'password' => ['required', 'string', 'min:8'],
        ],);
        // $user = DB::table('users')->get('name');
        $userLogin = DB::table('users')
            ->where('email', $email)
            ->Where('password',  $password)
            ->get();


        if ($validator->fails()) {
            $errors =  $validator->errors();
            return $errors;
            // return response()->json(['login' => "Bạn đã nhập sai thông tin đặng nhập, vui long nhập lại"]);
        } else {
            foreach ($userLogin as $user) {
                if (($request->email == $user->email) && ($request->password == $user->password)) {

                    return response()->json([

                        'login' => $userLogin,
                        'success' => 'Đăng nhập thành công'

                    ]);
                } else if (($user->email == false) && ($user->password == false)) {
                    return "hello";
                }
            }
        }
    }

    //change profile
    public function update(Request $request, $id)
    {
        // dd($request);
        //
        $params = $request->all();
        // dd($params);
        $validator = validator::make($params, [
            'name' => ['required', 'string', 'max:50',],
            'email' => ['required', 'string', 'email', 'max:255',],
            'password' => ['required', 'string', 'min:8'],
        ],);



        $change = DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash::make($request->password)
            ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors;
        }
        return response()->json([
            "update" => $change,
            "success" => "update thành công"
        ]);
    }

    //Reset-Password
    public function ResetPassword(Request $request)
    {

        DB::transaction(function () use ($request) {

            // - Việc 1 : Gửi 1 mã số có 4 chữ số về email người dùng truyền lên, với định dạng text : "Code khôi phục mật khẩu của bạn là : 1111, vui lòng không tiết lộ code này với bất kỳ ai". 



            $email     = $request->get('email', '');
            $password  = $request->get('password', '');
            $params    = $request->all();
            //b1 validate
            $validator = validator::make($params, [
                'email' => ['required', 'string', 'email', 'max:255',],
            ],);
            //Truy xuất database

            //Gửi mail
            if ($validator->fails()) {
                $errors = $validator->errors();
                return $errors;
            } else {
                $user = DB::table('users');
                $userORM = DB::table('users')
                    ->Where('email', $email)
                    ->get();

                // $user = User::find(5)->get('VerifiedCode');
                // dd($user);
                // dd($SendCode);
                foreach ($userORM as $value) {
                    $user = $value->VerifiedCode;

                    // xử lí gửi mail
                    $mailLable = new SendRecoveryCode($user);
                    $sendMail = Mail::to("phamhoangtuxx@gmail.com")->send($mailLable);
                    return $user;
                }
            }
            // return view('users.register');

        });
    }
}
