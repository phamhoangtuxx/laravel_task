<?php

namespace App\Http\Controllers\class_room;

use  App\Http\Controllers\class_room;


use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * 1. Filter theo nguoi tao, nhap id bao nhieu, filter ra danh sach nguoi tao do
     * 2. Tao migration them 1 field la State table Classroom, integer (0: un-active, 1: active)
     * 3. Filter theo State (trang thai) cua lop hoc, truyen 1 thi lay ra danh sach lop hoc kich hoat, con ko thi ko kich hoat, mac dinh lay het (0,1)s
     * 4. Cho phep sap xep theo name, createdat, classroomId, tang dan hoac giam dan
     * 5. Neu danh sach ban ghi loc ra, hoac tim kiem khong co ket qua tra ve, return message khong co du lieu
     * 6. Viet 1 function dung chung cho response tra ve thanh cong, va tra ve loi (5)
     */
    public function index(Request $request)
    {
        //Lay danh sach module classroom (pagination, filter)
        $per_page = $request->get('per_page', config('define.LIMIT_DEFAULT')); //mac dinh la 15 neu ko truyen
        $per_page = ($per_page > 10) ? config('define.LIMIT_DEFAULT') : $per_page;
        // ----------------------------------------Validate---------------------------------------------
        // DB::table('class_room')->get();

        // $params = $request->all();

        //DÙng validator để xác thực lỗi và lặp ra các rule
        // $validator = validator::make($params, [
        //     'name' => 'required|min:3|max:20',
        //     'classroomID'   => 'required',
        //     'createdBy' => 'required|numeric',
        //     'state' => 'required|numeric|min:0|max:1',
        //     // 'mobile' => 'required|digits:10',
        // ],);


        //------------------------------------------------------------------------------------------
        // 1. Filter theo nguoi tao, nhap id bao nhieu, filter ra danh sach nguoi tao do*/
        $createdByuser  = $request->get('createdByuser', 'createdBy'); //Lấy danh sách ng tạo 


        // * 2. Tao migration them 1 field la State table Classroom, integer (0: un-active, 1: active) đã xong 

        // * 3. Filter theo State (trang thai) cua lop hoc, truyen 1 thi lay ra danh sach lop hoc kich hoat, con ko thi ko kich hoat, mac dinh lay het (0,1)
        $status = $request->get('status', 'state');
        if ($status == '') {
            return "Bạn chưa chuyền cho state";
        }
        // if ($status == '') {
        //     return $request->get('state', 1);
        // }
        // echo $_GET['state'];

        // * 4. Cho phep sap xep theo name, createdat, classroomId, tang dan hoac giam dan

        $name = $request->get('name', 'ASC');
        $classroom_ID = $request->get('classroom_ID', 'ASC');
        $createdAT   = $request->get('created_at', 'ASC');


        $name = $request->get('name', 'ASC');
        $classrooms = DB::table('class_room')
            ->where('createdBy', $createdByuser)


            ->orWhere('state', $status)
            ->orderBy('name', $name)
            ->orderBy('classroomID', $classroom_ID)->limit(10)
            ->orderBy('created_at', $createdAT)


            //NHập odir=id...hoặc ....
            ->paginate($per_page);
        // dd($classrooms->name);
        $response = [
            'Data'        => $classrooms->items(), //Cuc data tra ve co cai gi ?
            'TotalItem'   => $classrooms->total(), //So luong data tra ve la bao nhieu dong
            'TotalPage'   => $classrooms->lastPage(), //So luong trang la bao nhieu ?
            'CurrentPage' => $classrooms->currentPage(), //Trang dang dung
            'PerPage'     => (int)$classrooms->perPage(), //So luong ban ghi tren 1 trang
        ];
        return response()->json(['Classroom' => $response]);
    }


    //Create class_room
    public function CreateUserClassroom(Request $request)
    {
        // echo "hello word";
        $params = $request->all();
        $state = $request->get('state', '0');
        $name = $request->get('name', '');
        $validator = validator::make($params, [
            'name' => ['required', 'string', 'max:20'],
            'state' => 'required|numeric|min:0|max:1',

        ],);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            return $errors;
        } else {
            DB::table('class_room')
                ->where('name', $name)
                ->orWhere('state', $state)
                ->insert([
                    'name' => $name,
                    'state' => $state
                ]);
            return response()->json(['message' => 'Đã thêm thành công']);
        }
    }

    //Update class_room
    public function UpdateClassroom(Request $request, $id)
    {
        $name = $request->get('name', '');
        $state = $request->get('state', '');
        $update = DB::table('class_room')
            ->where('id_classroom', $id)
            ->update([
                'name' => $name,
                'state' => $state,
            ]);
        return response()->json(['ListUpdate' => $update]);
    }
    public function DeleteClassroom(Request $request, $id)
    {

        $delete = DB::table('class_room')
            ->where('id_classroom', $id)
            ->delete();

        return response()->json(['delete' => 'Số dòng đã xóa' . $delete]);
    }



    //Create member
    public function InviteMember(Request $request)
    {

        $params = $request->all();
        $validator = validator::make($params, [
            'member_id' => ['required', 'integer', 'max:20',],
            'classroom_id' => ['required', 'integer', 'max:20',],
        ],);

        if ($validator->fails()) {
            $errors =  $validator->errors();
            return $errors;
        }
        $classroomId = $request->get('id_classroom', '');
        $MemberID = $request->get('member_id', '');

        if ($classroomId && $MemberID) {
            $isExits = DB::table('classroom_member')
                ->where('member_id', $MemberID)->exits();
            if ($isExits == false) return "member Không tồn tại";

            $InviteMember = DB::table('classroom_member')
                ->where('member_id', $MemberID)->exits()
                ->insert([
                    'state' => 0,
                    'AcceptAt' => now()
                ]);
        }
    }

    //Invite member
    public function confirmMember(Request $request)
    {

        $params = $request->all();
        $validator = validator::make($params, [
            'member_id' => ['required', 'integer', 'max:20',],
            'classroom_id' => ['required', 'integer', 'max:20',],
        ],);

        if ($validator->fails()) {
            $errors =  $validator->errors();
            return $errors;
        }
        $classroomId = $request->get('id_classroom', '');
        $MemberID = $request->get('member_id', '');

        if ($classroomId && $MemberID) {
            $isExits = DB::table('classroom_member')
                ->where('member_id', $MemberID)->exits();
            if ($isExits == false) return "member Không tồn tại";

            $InviteMember = DB::table('classroom_member')
                ->where('member_id', $MemberID)->exits()
                ->update([
                    'state' => 1,
                    'AcceptAt' => now()
                ]);
        }
    }
}
