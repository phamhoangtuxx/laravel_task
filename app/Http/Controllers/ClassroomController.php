<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index()
    {
        $insert =  DB::table('class_room');
        return response()->json([
            $insert->insert([
                'name' => 'truongDinhHoang',
                'icon' => 'icon sun',
                'description' => 'doanmota'
            ])
        ]);
    }
}
