<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //Phần Trang 
        // $User  = DB::table('users')->Paginate(5);
        // return response()->json([
        //     'User' => $User
        // ]);


        //Giới hạn số trang hiển thị
        // $User  = DB::table('users')
        //     ->offset(0)
        //     ->Limit(5)
        //     ->get();
        // return response()->json([
        //     'User' => $User
        // ]);

        // Seach theo tên
        $User  = DB::table('users')
            ->where('name', 'like', '%u')
            ->get();

        return response()->json([
            'User' => $User
        ]);
    }
}
