<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $module;
    public $breadcrumb;
    public $title;

    public function openView($view, $data = [])
    {
        $data['breadcrumb'] = $this->breadcrumb;
        $data['title'] = $this->title;
        $data['module'] = $this->module;
        return view($view, $data);
    }
}