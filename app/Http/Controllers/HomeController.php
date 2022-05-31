<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IInvoice;
use App\Models\OInvoice;
use App\Models\Customer;
use App\Models\User;
use App\Models\Distributor;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->breadcrumb = [
            'object'    => 'Trang chủ',
            'page'      => ''
        ];
        $this->module = 'dashboard';
        $this->title = 'Trang chủ';
    }

    public function index()
    {
        return $this->openView('modules.dashboard.dashboard');
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('status_admin', 'Tên đăng nhập hoặc mật khẩu không đúng');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function getIInvoice()
    {
        $total = 0;
        $total = IInvoice::all()->count();
        return response()->json([
            'status' => 'success',
            'data' => $total,
        ], 200);
    }

    public function getOInvoice()
    {
        $total = 0;
        $total = OInvoice::all()->count();
        return response()->json([
            'status' => 'success',
            'data' => $total,
        ], 200);
    }

    public function getCustomer()
    {
        $total = 0;
        $total = Customer::all()->count();
        return response()->json([
            'status' => 'success',
            'data' => $total,
        ], 200);
    }

    public function getDistributor()
    {
        $total = 0;
        $total = Distributor::all()->count();
        return response()->json([
            'status' => 'success',
            'data' => $total,
        ], 200);
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

    public function getListIInvoice(Request $request)
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

        $totalRecords  = IInvoice::all()->count();

        $i_invoice = IInvoice::select(['i_invoices.*'])
            ->leftjoin('distributors', 'distributors.id', '=', 'i_invoices.distributor_id')
            ->leftjoin('users', 'users.id', '=', 'i_invoices.user_id')
            ->leftjoin('discount_types', 'discount_types.id', '=', 'i_invoices.discount_type_id')
            ->with(['distributor'])
            ->with(['discount_type'])
            ->with(['user'])
            ->orderBy('date', 'desc')
            ->take(10)
            ->orderBy($columnName, $columnSortOrder)->get();

        $totalRecordswithFilter = 0;
        foreach ($i_invoice as $item) {
            $totalRecordswithFilter++;
        }
        $response = array(
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $i_invoice,
            "filter"               => $filter,
        );
        echo json_encode($response);
        exit;
    }

    public function getListOInvoice(Request $request)
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

        $totalRecords  = OInvoice::all()->count();

        $o_invoices = OInvoice::select(['o_invoices.*'])
            ->leftjoin('customers', 'customers.id', '=', 'o_invoices.customer_id')
            ->leftjoin('users', 'users.id', '=', 'o_invoices.user_id')
            ->with(['customer'])
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->orderBy($columnName, $columnSortOrder)->get();

        $totalRecordswithFilter = 0;
        foreach ($o_invoices as $item) {
            $totalRecordswithFilter++;
        }

        $response = array(
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $o_invoices,
            "filter"               => $filter,
        );
        echo json_encode($response);
        exit;
    }
}
