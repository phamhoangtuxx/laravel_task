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

        // dd($validator);



        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors;
        } else {
            $change = DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => hash::make($request->password)
                ]);
        }
        return response()->json([

            "update" => $change,
            "success" => "update thành công"
        ]);
    }

    //Reset-Password
    public function ResetPassword(Request $request)
    {


        $params    = $request->all();
        //b1 validate
        $validator = validator::make($params, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ],);


        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors;
        } else {
            // DB::transaction(function () use ($request) {
            $email = $request->get('email', '');

            $userORM = DB::table('users')
                ->where('email', $email)
                ->first();
            //Nếu email tồn tại và có dữ lệu thì thực hện send mail
            if ($userORM && !is_null($userORM)) {
                //Send mail
                $mailLable = new SendRecoveryCode($userORM);
                Mail::to($email)->send($mailLable);


                $VerifiedCode = rand(1111, 9999);
                $update = DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'VerifiedCode' => $VerifiedCode,
                    ]);

                //Get userID
                $userId =  DB::table('users')
                    ->where('email', $email)
                    ->value('id');

                $history_email = DB::table('historyemail')
                    ->insert([
                        'user_id' => $userId
                    ]);
                if ($history_email == true) {
                    return response()->json([
                        'success' => "đăng nhập thành công"
                    ]);
                } else {
                    echo "thất bại";
                }
            } else {
                return response()->json(['GỬi mail thất bại']);
            }
            // });
        }
    }
}
