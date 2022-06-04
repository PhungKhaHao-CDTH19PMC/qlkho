<?php

namespace App\Http\Controllers;
use App\Models\Contract;
use App\Models\User;
use App\Models\ContractExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractExtensionController extends Controller
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

    public function index($id)
    {
        $user = User::all();
        $Contract = Contract::find($id);
        $this->breadcrumb['page'] = 'Danh sách';
        $data = [
            'contract' => $Contract,
            'users'      => $user,
            'id'      => $id,
        ];
        // dd($data);
        return $this->openView("modules.{$this->module}.renewal", $data);
    }

    public function create($id)
    {
        $contract = Contract::find($id);
        $this->breadcrumb['page'] = 'Thêm mới';
        $data = [
            'contract'         => $contract,
        ];
        $this->title = 'Thêm mới';
        return $this->openView("modules.{$this->module}.renewal_create", $data);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'renewal_date_start' => 'required',
                'renewal_date_finish' => 'required',
                'salary_factor' => 'required',
            ],
            [
                'renewal_date_start.required' => 'Bạn chưa chọn ngày bắt đầu gia',
                'renewal_date_finish.required' => 'Bạn chưa chọn ngày kết thúc',
                'salary_factor.required' => 'Bạn nhập hệ số lương',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $newRenewal = ContractExtension::create([
            'contract_id'             =>  $request->contract_id,
            'renewal_date_start'      =>  $request->renewal_date_start,
            'renewal_date_finish'     =>  $request->renewal_date_finish,
            'salary_factor'           =>  $request->salary_factor,
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Thêm thành công',
                'redirect' => route('contracts.renewal', ['id'=>$request->contract_id])
            ],
            200
        );
    }

    public function edit($id)
    {
        $contractExtension = ContractExtension::find($id);
        $data = [
            'contractExtension'   => $contractExtension,
        ];
        $this->title = 'Cập nhật';
        return $this->openView("modules.{$this->module}.renewal_update", $data);
    }

    public function update(Request $request)
    {
        // dd(  $request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'renewal_date_start' => 'required',
                'renewal_date_finish' => 'required',
                'salary_factor' => 'required',
            ],
            [
                'renewal_date_start.required' => 'Bạn chưa chọn ngày bắt đầu gia',
                'renewal_date_finish.required' => 'Bạn chưa chọn ngày kết thúc',
                'salary_factor.required' => 'Bạn nhập hệ số lương',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $update = ContractExtension::find($request->id);
        $update->renewal_date_start = $request->renewal_date_start;
        $update-> renewal_date_finish = $request->renewal_date_finish;
        $update-> salary_factor = $request->salary_factor;
        $update->save();
        if (!empty($update)) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Cập nhật thành công',
                    'redirect' => route('contracts.renewal', ['id'=>$request->contract_id])
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

    public function destroy(Request $request)
    {
        try {
            ContractExtension::destroy($request->id);
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
    public function loadAjaxListRenewal(Request $request)
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
        $totalRecords  = ContractExtension::where('contract_id', $request->contract_id)->count();
        $totalRecordswithFilter = ContractExtension::where('contract_id', $request->contract_id)->distinct()->count();
        $contract_extension = ContractExtension::where('contract_id', $request->contract_id)->select(['contract_extensions.*', 'contracts.code' , 'contracts.user_id'])
        ->leftjoin('contracts', 'contracts.id', '=', 'contract_extensions.contract_id')
        ->leftjoin('users', 'users.id', '=', 'contracts.user_id')
        ->with(['contract'])
        ->with(['user'])
        ->orderBy($columnName, $columnSortOrder)->distinct()->skip($start)->take($rowperpage)->get();

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $contract_extension,
            "filter"               => $filter,
        ];
        echo json_encode($response);
        exit;
    }
}
