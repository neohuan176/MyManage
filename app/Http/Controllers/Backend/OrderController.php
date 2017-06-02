<?php

namespace App\Http\Controllers\Backend;

use App\CompanyRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $paginate = 10;
    public function __construct()
    {
        $this->middleware('auth');
    }

    //显示所有公司订单
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示公司订单
     */
    public function companyOrdersManage(Request $request){
        $orders = CompanyRecord::paginate($this->paginate);
        return view('backend.orders.companyOrders',['orders'=>$orders]);
    }

    //导出所有公司订单

    //显示所有个人订单
    //导出所有个人订单

    //显示所有常规订单
    //导出所有常规订单
}
