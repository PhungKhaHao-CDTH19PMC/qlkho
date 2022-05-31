<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->module = 'account';
        $this->breadcrumb = [
            'object'    => 'Tài khoản',
            'page'      => ''
        ];
        $this->title  = 'Quản lý tài khoản';
    }
    public function edit($id)
    {
        if (auth()->user()->id != $id) {
            return back()->withErrors(['failed' => "Vui lòng không cập nhật tài khoản khác"]);
        };
        $role = Role::all();
        $user = User::find($id);
        $this->breadcrumb['page'] = 'Cập nhật';
        $this->title = 'Cập nhật tài khoản';
        return $this->openView("modules.{$this->module}.update", ['roles' => $role, 'user' => $user]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required',
                'username' => 'required|unique:App\Models\User,username,' . $request->id,
                'email' => 'required|unique:App\Models\User,email,' . $request->id,
                'phone' => 'required|unique:App\Models\User,phone,' . $request->id,
                'address' => 'required',
                'role_id' => 'required',
            ],
            [
                'fullname.required' => 'Họ tên không được trống',
                'username.required' => 'Tên đăng nhập không được trống',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.required' => 'Số điện thoại không được trống',
                'address.required' => 'Địa chỉ không được trống',
                'role_id.required' => 'Chưa chọn chức vụ',
            ]
        );
        if ($validator->fails()) {
            return back()->with('error', $validator->messages()->first());
        }
        $user = User::find($id);
        if ($user == null) {
            return back()->with('error', 'Không tìm thấy nhân viên này');
        }
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = preg_replace('/\s+/', '', $request->phone);
        $user->address = $request->address;
        $user->role_id = $request->role_id;
        $user->save();
        return back()->with('status', 'Cập nhật thành công');
    }
    public function edit_pass()
    {
        $this->breadcrumb['page'] = 'Cập nhật mật khẩu';
        return view("modules.{$this->module}.update_pass", ['module' => $this->module, 'breadcrumb' => $this->breadcrumb,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_pass(Request $request, $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return back()->with('error', 'Không tìm thấy nhân viên này');
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Mật khẩu sai! Hãy nhập lại');
        } elseif ($request->new_password != $request->enter_new_pass) {
            return back()->with('error', 'Mật khẩu không trùng khớp! Hãy nhập lại');
        }
        if (strlen($request->new_password) < 6) {
            return back()->with('error', 'Nhập mật khẩu mới ít nhất 6 kí tự');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('status', 'Cập nhật thành công');
    }
}