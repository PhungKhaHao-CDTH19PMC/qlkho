<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->module = 'Timesheet';
        $this->breadcrumb = [
            'object'    => 'Chấm công',
            'page'      => ''
        ];
        $this->title = 'Chấm công';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        // $monthNow =substr(Carbon::now()->format('d-m-Y H:i:s'),4,7);
        // Carbon::now()->format('d-m-Y H:i:s')
        $Timesheet = Timesheet::all();
        $dateTimesheet = Timesheet::where('id','>',0)->selectRaw("substring(in_hour,4,7)")->distinct()->get();
        // $salary = Salary::all();
      $endate =(int) Carbon::now()->endOfMonth()->format('d');
    //   dd((int)Carbon\Carbon::parse($Timesheet->in_hour)->format('d'));
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'Timesheets' => $Timesheet,
            'users'      => $user,
            'endate'    => $endate,
            'dateTimesheets' => $dateTimesheet
        ];
        // dd($Timesheet    ); 
        return $this->openView("modules.{$this->module}.list", $data);
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

    public function loadAjaxListTimesheet(Request $request)
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
        $totalRecords  = Timesheet::count();
        $totalRecordswithFilter = Timesheet::queryData($filter)->distinct()->count();
        $PaySalary = Timesheet::select(['timesheets.*'])
        ->with(['user'])
        // ->with(['salarys'])
        ->QueryData($filter)
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();
        // dd($filter);
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $PaySalary,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $salary = Timesheet::all();
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'users'         => $user,
            'Timesheets'    =>$salary,
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
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'working_day' => 'required',
                'salary' => 'required',
                'allowance' => 'required',
                'user_id' =>  'required',
                'total' => 'required',
                'advance' => 'required',
                'actual_salary' => 'required',
                'status' => 'required',
            ],
            [
                'working_day.required' => 'Bạn chưa nhập số ngày công',
                'salary.required' => 'Bạn chưa nhập lương',
                'allowance.required' => 'Bạn chưa nhập trợ cấp',
                'user_id.required' => 'Bạn chưa chọn nhân viên',
                'total.required' =>'Bạn chưa có tổng lương',
                'advance.required' =>'Bạn chưa nhập ứng lương',
                'actual_salary.required' =>'Bạn chưa nhập lương thực tế',
                'status.required' =>'Bạn chưa chọn trạng thái',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $monthNow =substr(Carbon::now()->format('d-m-Y H:i:s'),4,7);
        $checkPaySalary = PaySalary::where('user_id',$request->user_id)->where('month','LIKE',"%$monthNow%")->count();
        if($checkPaySalary>0)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhân viên này đã được tính lương tại tháng hiện tại!',
            ], 200);
        }
        $Contract = Contract::where('user_id',$request->user_id)->first();
// dd(Carbon::now()->format('d-m-Y H:i:s'));
        $newPaySalary = PaySalary::create([
            'salary_id'     =>  $Contract->salary_id,
            'user_id'       =>  $request->user_id,
            'working_day'   =>  $request->working_day,
            'salary'        =>  $request->salary,
            'allowance'     =>  $request->allowance,
            'total'         =>  $request->total,
            'advance'       =>  $request->advance,
            'actual_salary' =>  $request->actual_salary,
            'month'         =>  Carbon::now()->format('d-m-Y H:i:s'),
            'status'        =>  $request->status,
        ]);
// dd( $newPaySalary);
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
        $PaySalary = PaySalary::find($id);
        // dd($PaySalary);
        $user = User::where('id',$PaySalary->user_id)->first();
        $Contract = Contract::where('user_id',$PaySalary->user_id)->first();
        $salary = Salary::find(  $Contract->salary_id);
        $data = [
            'user'         => $user,
            'PaySalary'  => $PaySalary,
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
                'working_day' => 'required',
                'salary' => 'required',
                'allowance' => 'required',
                'user_id' => 'required',
                'total' => 'required',
                'advance' => 'required',
                'actual_salary' => 'required',
                'status' => 'required',
            ],
            [
                'working_day.required' => 'Bạn chưa nhập số ngày công',
                'salary.required' => 'Bạn chưa nhập lương',
                'allowance.required' => 'Bạn chưa nhập trợ cấp',
                'user_id.required' => 'Bạn chưa chọn nhân viên',
                'total.required' =>'Bạn chưa có tổng lương',
                'advance.required' =>'Bạn chưa nhập ứng lương',
                'actual_salary.required' =>'Bạn chưa nhập lương thực tế',
                'status.required' =>'Bạn chưa chọn trạng thái',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $Contract = Contract::where('user_id',$request->user_id)->first();
        $update = PaySalary::find($request->id);
        
        $update-> salary_id = $Contract->salary_id;
        $update->working_day = $request->working_day;
        $update-> salary = $request->salary;
        $update-> allowance = $request->allowance;
        $update-> user_id = $request->user_id;
        $update-> total = $request->total;
        $update-> advance = $request->advance;
        $update-> actual_salary = $request->actual_salary;
        $update->month  = Carbon::now()->format('d-m-Y H:i:s');

        $update-> status = $request->status;
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
            PaySalary::destroy($request->id);
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

   
}
