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
            // return response()->json(['login' => "B???n ???? nh???p sai th??ng tin ?????ng nh???p, vui long nh???p l???i"]);
        } else {
            foreach ($userLogin as $user) {
                if (($request->email == $user->email) && ($request->password == $user->password)) {

                    return response()->json([

                        'login' => $userLogin,
                        'success' => '????ng nh???p th??nh c??ng'

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
            "success" => "update th??nh c??ng"
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
            //N???u email t???n t???i v?? c?? d??? l???u th?? th???c h???n send mail
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
                        'success' => "????ng nh???p th??nh c??ng"
                    ]);
                } else {
                    echo "th???t b???i";
                }
            } else {
                return response()->json(['G???i mail th???t b???i']);
            }
            // });
        }
    }

    public function emailStatic(Request $request)
    {
        //N???u th???ng k?? ko d??? li???u return v??? r???ng ho???c kh??ng c?? gi?? tr??? 
        $user = DB::table('users')
            ->join('historyemail as h', 'users.id', 'h.user_id')

            ->select('id', 'name', 'email', DB::raw('count(h.user_id) as TotalSendMail'))
            ->groupBy('users.id')
            ->get();

        if (isset($user) == true && null) {
            return response()->json([
                'list_user' => $user
            ]);
        } else {
            return response()->json(['message' => 'Kh??ng c?? d??? li???u tr??? v???']);
        }
    }


    //L???ch s??? th???i gian g???i mail  t??? user-id n??o
    public function historyEmail()
    {
        $user = DB::table('users')
            ->join('historyemail as h', 'users.id', 'h.user_id')
            ->select('id', 'name', 'email', 'sendmailAt')
            ->groupBy('users.id')
            ->get();
        return response()->json(['HistoryEmail' => $user]);
    }

    //get list user_sendmail
    public function staticSendmail(Request $request, $id)
    {
        if (is_numeric($id)) {
            $isExist = DB::table('users')->where('id', $id)->exists();

            if (!$isExist) {
                return response()->json(['errors' => "kh??ng c?? d??? li???u id"]);
            }

            $user = DB::table('users')
                ->where('id', $id)
                ->join('historyemail as h', 'users.id', 'h.user_id')
                ->select('id', 'name', DB::raw('count(h.sendmailAt) as TotalSendMail'))
                ->groupBy('users.id')
                ->first();

            return response()->json(['static_sendmail' => $user]);
        }

        return response()->json(['error' => 'User-Id must be integer']);
    }


    //Delete history
    public function removeHistory(Request $request, $id)
    {
        $user = DB::table('historyemail')->where('user_id', $id)->delete();

        return response()->json(['X??a th??nh c??ng' => $user . " " . 'd??ng']);
    }
    public function totalSendmail()
    {
        $user = DB::table('historyemail')->count();

        return response()->json([
            'system' => 'Laravel_Task',
            'TotalSendMailInSystem' => $user
        ]);
    }

    public function deleteUser($id)
    {
        //check user id co ton tai trong he thong hay khong?
        $isExist = DB::table('users')
            ->where('id', $id)
            ->exists();
        // dd($isExist);
        //0 true 1false
        //id 7 true
        //1. ko co -> ko ton tai

        if (($isExist)) {
            DB::table('users')
                ->where('id', $id)
                ->update(['is_deleted' => 1]);
            return response()->json([
                "message" => "Delete Th??nh conc"
            ]);
        } else {
            return response()->json([
                "user_id" => "User-id Kh??ng T???n t???i"
            ]);
        }
    }
}
