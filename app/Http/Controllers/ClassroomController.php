<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index()
    {




        //Phần Trang 
        // $ClassRoom  = DB::table('class_room')->Paginate(5);
        // return response()->json([
        //     'classroom' => $ClassRoom
        // ]);


        //Giới hạn số trang hiển thị
        // $ClassRoom  = DB::table('class_room')
        //     ->offset(0)
        //     ->Limit(5)
        //     ->get();
        // return response()->json([
        //     'classroom' => $ClassRoom
        // ]);


        // Seach theo tên
        $class_room  = DB::table('class_room')
            ->where('name', 'like', '%r')
            ->get();

        return response()->json([
            'class_room' => $class_room
        ]);
    }
}
