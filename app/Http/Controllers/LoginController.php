<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email  = $request->get('email', ''); //Lấy danh sách ng tạo 
        $password  = $request->get('password', ''); //Lấy danh sách ng tạo 
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
