<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->module = 'user';
        $this->breadcrumb = [
            'object'    => 'Nhân viên',
            'page'      => ''
        ];
        $this->title = 'Người dùng';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = User::all();
        $user_phones = $user->where('phone', '!=', '')->pluck('phone')->sort();
        $user_fullnames = $user->pluck('fullname')->unique()->sort();
        $role = Role::orderBy('name', 'asc')->get();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'user'      => $user,
            'role' => $role,
            'user_phone' => $user_phones,
            'user_fullname' => $user_fullnames
        ];

        return $this->openView("modules.{$this->module}.list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code = 'NV'.User::max('id') + 1;
        $role = Role::all();
        $department = Department::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'roles'         => $role,
            'departments'   => $department,
            'code'   => $code,
        ];
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'username' => 'required|unique:App\Models\User,username,NULL,id,deleted_at,NULL',
                'password' => 'required',
                'birthday' => 'required',
                'phone' => 'required|unique:App\Models\User,phone,NULL,id,deleted_at,NULL',
                'address' => 'required',
                'citizen_identification' => 'required|unique:App\Models\User,citizen_identification,NULL,id,deleted_at,NULL',
                'email' => 'required|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
                'role_id' => 'required',
                'department_id' => 'required',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'username.required' => 'Tên đăng nhập không được trống',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'password.required' => 'Mật khẩu không được trống',
                'birthday.required' => 'Ngày sinh không được trống',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'role_id.required' => 'Chưa chọn chức vụ',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
       $user = User::create(
            [
                'code'                      => $request->code,
                'fullname'                  => $request->fullname,
                'username'                  => $request->username,
                'password'                  => Hash::make($request->password),
                'birthday'                  => $request->birthday,
                'phone'                     => preg_replace('/\s+/', '', $request->phone),
                'address'                   => $request->address,
                'citizen_identification'    => $request->citizen_identification,
                'email'                     => $request->email,
                'role_id'                   => $request->role_id,
                'department_id'             => $request->role_id
            ]
        );
        if($user)
        {
            $role = Role::find($request->role_id);
            $user->assignRole($role->name);
        }
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Thêm thành công',
                'redirect' => route($route)
            ],
            200
        );
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
        $role = Role::all();
        $this->breadcrumb['page'] = 'Cập nhật';
        $user = User::find($id);
        $department = Department::all();
        $data = [
            'user'      => $user,
            'roles' => $role,
            'departments'   => $department,
        ];
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.update", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'username' => "required|unique:App\Models\User,username,{$request->id},id,deleted_at,NULL",
                'email' => "required|unique:App\Models\User,email,{$request->id},id,deleted_at,NULL",
                'phone' => "required|unique:App\Models\User,phone,{$request->id},id,deleted_at,NULL",
                'citizen_identification' => "required|unique:App\Models\User,citizen_identification,{$request->id},id,deleted_at,NULL",
                'address' => 'required',
                'role_id' => 'required',
                'department_id' => 'required',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'username.required' => 'Tên đăng nhập không được trống',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'citizen_identification.unique' => 'CMND/CCCD đã tồn tại',
                'citizen_identification.required' => 'CMND/CCCD không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'role_id.required' => 'Chưa chọn chức vụ',
                'department_id.required' => 'Chưa chọn phòng ban',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find($request->id);
        if (!empty($user)) {
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->birthday = $request->birthday;
            $user->citizen_identification = $request->citizen_identification;
            $user->email = $request->email;
            $user->phone = preg_replace('/\s+/', '', $request->phone);
            $user->address = $request->address;
            $user->role_id = $request->role_id;
            $user->department_id = $request->department_id;
            $user->save();
        }
        $listRole = explode(",", $request->role_id);
        $delete_roles = Role::whereNotIn('id',$listRole)->get();
        foreach($delete_roles as $delete_role)
        {
            $user->removeRole($delete_role->name);
        }

        foreach($listRole as $id)
        {
            $role = Role::find($id);
            $user->assignRole($role->name);
        }
        $route = "{$this->module}.list";
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Cập nhật thành công',
                'redirect' => route($route)
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            User::destroy($request->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Đã xoá dữ liệu',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy yêu cầu',
            ], 200);
        }
    }

    public function customFilterAjax($filter, $columns)
    {
        if (!empty($columns)) {
            foreach ($columns as $column) {
                if ($column["search"]["value"] != null) {
                    $filter[$column["name"]] = $column["search"]["value"];
                }
            }
        }
        return $filter;
    }

    public function loadAjaxListUser(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowperpage      = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = trim($search_arr['value']); // Search value
        $filter['search'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords  = User::count();
        $totalRecordswithFilter = User::queryData($filter)->distinct()->count();
        $user = User::select(['users.*'])
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->with(['role'])
            ->queryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $user,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }

    public function loadFilterUser(Request $request)
    {
        $filteredObjects['fullname'] = [];
        $filteredObjects['phone']= [];
        $filteredObjects['role_id'] = [];

        $arrFullname = json_decode(($request->fullname));
        $arrPhone = json_decode(($request->phone));
        $arrRoleId = json_decode(($request->role_id));

        if($arrFullname==null)
        {
            if($arrPhone==null)
            {
                if($arrRoleId==null)
                {
                    $users= User::all();
                    foreach($users as $user)
                    {
                        if(!empty($user->fullname))
                        {
                            $flag = false;
                            foreach($filteredObjects['fullname'] as $fullname){
                                if($fullname==$user->fullname)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['fullname'],$user->fullname);
                            }
                        }
                        if(!empty($user->phone))
                        {
                            $flag = false;
                            foreach($filteredObjects['phone'] as $phone){
                                if($phone==$user->phone)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['phone'],$user->phone);
                            }
                        }
                    }
                    $roles= Role::all();
                    foreach($roles as $role)
                    {
                        array_push($filteredObjects['role_id'],$role);
                    }
                }
                else
                {
                    foreach($arrRoleId as $roleId)
                    {
                        $users= User::where('role_id', $roleId)->get();
                        foreach($users as $user)
                        {
                            if(!empty($user->fullname))
                            {
                                $flag = false;
                                foreach($filteredObjects['fullname'] as $fullname){
                                    if($fullname==$user->fullname)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['fullname'],$user->fullname);
                                }
                            }
                            if(!empty($user->phone))
                            {
                                $flag = false;
                                foreach($filteredObjects['phone'] as $phone){
                                    if($phone==$user->phone)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['phone'],$user->phone);
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                if($arrRoleId==null)
                {
                    foreach($arrPhone as $phone)
                    {
                        $user= User::where('phone', $phone)->first();
                        if(!empty($user->fullname))
                        {
                            $flag = false;
                            foreach($filteredObjects['fullname'] as $fullname){
                                if($fullname==$user->fullname)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['fullname'],$user->fullname);
                            }
                        }
                        if(!empty($user->role_id))
                        {
                            $roles= Role::find($user->role_id);
                            $flag = false;
                            foreach($filteredObjects['role_id'] as $role){
                                if($role['id']==$roles->id)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['role_id'],$roles);
                            }
                        }
                    }
                }
                else
                {
                    foreach($arrPhone as $phone)
                    {
                        foreach($arrRoleId as $roleId)
                        {
                            $users= User::where('phone', $phone)->where('role_id', $roleId)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->fullname))
                                {
                                    $flag = false;
                                    foreach($filteredObjects['fullname'] as $fullname){
                                        if($fullname==$user->fullname)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['fullname'],$user->fullname);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
            if($arrPhone==null)
            {
                if($arrRoleId==null)
                {
                    foreach($arrFullname as $fullname)
                    {
                        $users= User::where('fullname',$fullname)->get();
                        foreach($users as $user)
                        {
                            if(!empty($user->phone))
                            {
                                $flag = false;
                                foreach($filteredObjects['phone'] as $phone){
                                    if($phone==$user->phone)
                                    {
                                        $flag = true;
                                        break;
                                    }
                                }
                                if(!$flag){
                                    array_push($filteredObjects['phone'],$user->phone);
                                }
                            }
                            $roles= Role::find($user->role_id);
                            $flag = false;
                            foreach($filteredObjects['role_id'] as $role){
                                if($role['id']==$roles->id)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                            if(!$flag){
                                array_push($filteredObjects['role_id'],$roles);
                            }
                        }
                    }
                }
                else
                {
                    foreach($arrFullname as $fullname)
                    {
                        foreach($arrRoleId as $roleId)
                        {
                            $users= User::where('fullname',$fullname)->where('role_id', $roleId)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->phone))
                                {
                                    $flag = false;
                                    foreach($filteredObjects['phone'] as $phone){
                                        if($phone==$user->phone)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['phone'],$user->phone);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                if($arrRoleId==null)
                {
                    foreach($arrFullname as $fullname)
                    {
                        foreach($arrPhone as $phone)
                        {
                            $users= User::where('fullname',$fullname)->where('phone', $phone)->get();
                            foreach($users as $user)
                            {
                                if(!empty($user->role_id))
                                {
                                    $roles= Role::find($user->role_id);
                                    $flag = false;
                                    foreach($filteredObjects['role_id'] as $role){
                                        if($role['id']==$roles->id)
                                        {
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if(!$flag){
                                        array_push($filteredObjects['role_id'],$roles);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $filteredObjects;
    }
    public function checkRole()
    {
        $super_Admin = Auth::user()->hasRole('Super Admin');
        $permisionDelete = Auth::user()->hasPermissionTo('Xoá người dùng');
        if($super_Admin || $permisionDelete)
        {
            return true;
        }
        return false;
    }
}