<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Salary;

use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->module = 'contracts';
        $this->breadcrumb = [
            'object'    => 'Hợp đồng',
            'page'      => ''
        ];
        $this->title = 'Hợp đồng';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        $Contract = Contract::all();
        $salary = Salary::all();

        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'contract' => $Contract,
            'users'      => $user,
            'salary'    =>$salary
        ];
        // dd($data);
        return $this->openView("modules.{$this->module}.list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $salary = Salary::all();

        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'salary'    =>$salary,
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
        // dd(Carbon::parse($request->start_date)->format('d-m-Y'));
        $validator = Validator::make(
            $request->all(),
            [
                'start_date' => 'required',
                'finish_date' => 'required',
                'signing_date' => 'required',
                'renewal_date' => 'required',
                'user_id' => 'required',
                'content' => 'required',
                // 'renewal_number' => 'required',
                'salary_id' => 'required',
                'salary_factor' => 'required',

            ],
            [
                'start_date.required' => 'Bạn chưa chọn ngày bắt đầu',
                'finish_date.required' => 'Bạn chưa chọn ngày kết thúc',
                'signing_date.required' => 'Bạn chưa chọn ngày kí hợp đồng',
                'renewal_date.required' => 'Bạn chưa chọn ngày gia hạn',
                'content.required' => 'Bạn chưa nhập nội dung',
                'renewal_number.required' => 'Bạn chưa nhập số lần gia hạn',
                'salary_id.required' =>'Bạn chưa chọn loại lương',
                'salary_factor.required' =>'Bạn chưa nhập hệ số lương',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newContract = Contract::create([
            'start_date' =>$request->start_date,
            'finish_date' =>$request->finish_date,
            'signing_date' =>$request->signing_date,
            'renewal_date' =>$request->renewal_date,
            'user_id' => $request->user_id,
            'content' => $request->content,
            'renewal_number' => 0,
            'salary_id' => $request->salary_id,
            'salary_factor' => $request->salary_factor,
            'code'   =>null
        ]);
        $update = Contract::where('id' , $newContract->id)->update(['code' => "HD.$newContract->id"]);
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
        $user = User::all();
        $contract = Contract::find($id);
        $salary = Salary::all();
        $data = [
            'users'         => $user,
            'contract'  => $contract,
            'salary'    =>$salary,
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
        // dd(  $request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'start_date' => 'required',
                'finish_date' => 'required',
                'signing_date' => 'required',
                'renewal_date' => 'required',
                'user_id' => 'required',
                'content' => 'required',
                // 'renewal_number' => 'required',
                'salary_id' => 'required',
                'salary_factor' => 'required',

            ],
            [
                'start_date.required' => 'Bạn chưa chọn ngày bắt đầu',
                'finish_date.required' => 'Bạn chưa chọn ngày kết thúc',
                'signing_date.required' => 'Bạn chưa chọn ngày kí hợp đồng',
                'renewal_date.required' => 'Bạn chưa chọn ngày gia hạn',
                'content.required' => 'Bạn chưa nhập nội dung',
                'renewal_number.required' => 'Bạn chưa nhập số lần gia hạn',
                'salary_id.required' =>'Bạn chưa chọn loại lương',
                'salary_factor.required' =>'Bạn chưa nhập hệ số lương',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $update = Contract::find($request->id);
        if($update->renewal_date != $request->renewal_date )
        {
            $update->renewal_number = $request->renewal_number+1;
        }
        $update->start_date = $request->start_date;
        $update-> finish_date = $request->finish_date;
        $update-> signing_date = $request->signing_date;
        $update-> renewal_date = $request->renewal_date;
        $update-> user_id = $request->user_id;
        $update-> content = $request->content;
        $update-> salary_id = $request->salary_id;
        $update-> salary_factor = $request->salary_factor;
        $update->save();
        if (!empty($update)) {
            $route = "{$this->module}.list";
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Cập nhật thành công',
                    'redirect' => route($route)
                ],
                200
            );
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
            Contract::destroy($request->id);
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
    public function loadAjaxListContract(Request $request)
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
        $filter['name'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);
        // Total records
        $totalRecords  = Contract::count();
        $totalRecordswithFilter = Contract::queryData($filter)->distinct()->count();
        $Contract = Contract::select(['Contracts.*'])
        ->with(['user'])
        ->with(['salary'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $Contract,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
