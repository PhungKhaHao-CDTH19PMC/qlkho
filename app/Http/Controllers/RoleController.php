<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Role_has_permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Model_has_role;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->module = 'role';
        $this->breadcrumb = [
            'object' => 'Phân quyền',
            'page' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::all();
        // $user_fullnames = User::where('fullname','!=','Super Admin')->pluck('fullname')->unique()->sort();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'breadcrumb' => $this->breadcrumb,
            'module' => $this->module,
            'roles_name' => $role,
            // 'user_fullname' => $user_fullnames

        ];
        return view("modules.{$this->module}.list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        // $user_fullnames = User::where('fullname','!=','Super Admin')->pluck('fullname')->unique()->sort();

        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'breadcrumb' => $this->breadcrumb,
            'module' => $this->module,
            'permissions' => $permissions,
            // 'user_fullname' => $user_fullnames

        ];
        return view("modules.{$this->module}.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->name);
        $validator = Validator::make(
            $request->all(),
            [
                'name' =>  "required|unique:Spatie\Permission\Models\Role,name, {$request->id},id",
            ],
            [
                'name.unique' => 'Tên quyền đã tồn tại',
                'name.required' => 'Tên quyền không được trống',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }


        
        $role = ModelsRole::create(['name' => $request->name]);
        foreach ($request->permission as $permission_id) {
            $permission = Permission::find($permission_id);
            $permission->assignRole($role);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
            'redirect' => route('role.list'),
        ], 200);
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
    public function edit(Request $request)
    {
        $id = $request->id;
        $Permission = Permission::all();
        $user_fullnames = User::where('fullname', '!=', 'Super Admin')->pluck('fullname')->unique()->sort();
        $role = Role::find($request->id);
        $permissionOfRole = Role_has_permission::where('role_id', $request->id)->get();
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'breadcrumb' => $this->breadcrumb,
            'module' => $this->module,
            'Permission' => $Permission,
            'role' => $role,
            'permissionOfRole' => $permissionOfRole,
            'user_fullname' => $user_fullnames,

        ];
        return view("modules.{$this->module}.update", $data);

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
        if (empty($request->role_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất 1 quyền',
            ], 200);
        }
        $ModelsRole = ModelsRole::find($request->id);
        $role = Role::find($request->id);

        $listPermisons = explode(",", $request->role_id);
        // $del_role = Role_has_permission::where('role_id',$role->id)->whereNotIn('permission_id',$listPermisons)->delete();
        // $delete_permissions = Permission::whereNotIn('id',$listPermisons)->get();
        // dd($role->listPermission);

        foreach ($role->listPermission as $delete_permission) {
            $ModelsRole->revokePermissionTo($delete_permission);
        }
        foreach ($listPermisons as $id) {
            $permission = Permission::find($id);
            $perminssionInRolle = $permission->assignRole($ModelsRole);
        }
        if (!empty($perminssionInRolle)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
                'redirect' => route('role.list'),
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thất bại',
            ], 200);
        }
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
            $checkRole = (Model_has_role::where('role_id',$request->id))->count();
            if( $checkRole == 0)
            {
                Role::destroy($request->id);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Đã xoá dữ liệu',
                    ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Vẫn còn nhân viên có chức vụ này không thể xoá được!',
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
    public function loadAjaxListRole(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = trim($search_arr['value']); // Search value
        $filter['search'] = $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords = Role::where('name', '!=', 'Super Admin')->count();
        $totalRecordswithFilter = Role::where('name', '!=', 'Super Admin')->queryData($filter)->distinct()->count();
        $roles = Role::select(['roles.*'])
            ->where('name','!=','Super Admin')
            ->QueryData($filter)
            ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        $data = [];
        foreach ($roles as $role) {
            $role["permission"] = $role->listPermission;
            array_push($data, $role);
        }
        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data,
            "filter" => $filter,
        ];
        echo json_encode($response);
        exit;
    }

}
