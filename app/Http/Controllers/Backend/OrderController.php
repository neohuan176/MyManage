<?php

namespace App\Http\Controllers\Backend;

use App\Client;
use App\ClientRecord;
use App\Company;
use App\CompanyRecord;
use App\Facade\exportExcelServiceFacade;
use App\OrdinaryOrder;
use App\OrdinaryRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $paginate = 10;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示公司订单
     */
    public function companyOrdersManage(Request $request){
        $type = $request->has('type')?$request->get('type'):1;
        $searchInput = "";
        if($request->has('searchInput')){
            $searchInput = $request->get('searchInput');
        }
        switch ($type){
            case 1:$orders = CompanyRecord::paginate($this->paginate);break;//查找全部
            case 2:$orders = CompanyRecord::whereIn('companyId',Company::where("company","like",'%'.$searchInput.'%')->pluck("id"))->paginate($this->paginate);break;//按照公司查找
            case 3:$orders = CompanyRecord::where('product','like','%'.$searchInput.'%')->paginate($this->paginate);break;//按照产品名称
        }

        $orders->each(function ($order){
            $order->companyInfo = Company::find($order->companyId);

        });
//        dd($orders);
        return view('backend.orders.companyOrders',['orders'=>$orders,'type'=>$type,'searchInput'=>$searchInput]);
    }

    /**
     * @param Request $request
     * 导出所有公司购买记录
     */
    public function exportCompanyOrders(Request $request){
        exportExcelServiceFacade::exportCompanyOrders();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示个人订单
     */
    public function ClientOrdersManage(Request $request){
        $type = $request->has('type')?$request->get('type'):1;
        $searchInput = "";
        if($request->has('searchInput')){
            $searchInput = $request->get('searchInput');
        }
        switch ($type){
            case 1:$orders = ClientRecord::paginate($this->paginate);break;//查找全部
            case 2:$orders = ClientRecord::whereIn('clientId',Client::where("name","like",'%'.$searchInput.'%')->pluck("id"))->paginate($this->paginate);break;//按照姓名查找
            case 3:$orders = ClientRecord::where('product','like','%'.$searchInput.'%')->paginate($this->paginate);break;//按照产品名称
        }

        $orders->each(function ($order){
            $order->clientInfo = Client::find($order->clientId);
        });
        return view('backend.orders.clientOrders',['orders'=>$orders,'type'=>$type,'searchInput'=>$searchInput]);
    }
    /**
     * @param Request $request
     * 导出所有个人购买记录
     */
    public function exportClientOrders(Request $request){
        exportExcelServiceFacade::exportClientOrders();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示常规订单
     */
    public function ordinaryOrdersManage(Request $request){
//        $type = $request->has('type')?$request->get('type'):1;
//        $searchInput = "";
//        if($request->has('searchInput')){
//            $searchInput = $request->get('searchInput');
//        }
//        switch ($type){
//            case 1:$orders = ClientRecord::paginate($this->paginate);break;//查找全部
//            case 2:$orders = ClientRecord::whereIn('clientId',Client::where("name","like",'%'.$searchInput.'%')->pluck("id"))->paginate($this->paginate);break;//按照姓名查找
//            case 3:$orders = ClientRecord::where('product','like','%'.$searchInput.'%')->paginate($this->paginate);break;//按照产品名称
//        }

//        $orders->each(function ($order){
//            $order->clientInfo = Client::find($order->clientId);
//        });
        $orders = OrdinaryOrder::paginate($this->paginate);
        return view('backend.orders.ordinaryOrders',['orders'=>$orders]);
    }

    /**
     * @param Request $request
     * @return array
     * 保存普通订单
     */
    public function addOrdinaryOrder(Request $request){
        $order = new OrdinaryOrder();
        $order->describe = $request->describe;
        $order->adminId = Auth::id();
        $order->time = date('Y-m-d h:i:s');
        $order->save();
        if( !empty( $request->records)) {
            $orderInfo = "";
            $totalPrice = 0;
            foreach ($request->records as $record) {
                $cur_record = new OrdinaryRecord();
                $cur_record->product = $record['product'];
                $cur_record->unit = $record['unit'];
                $cur_record->size = $record['size'];
                $cur_record->unitPrice = $record['unitPrice'];
                $cur_record->count = $record['count'];
                $cur_record->totalPrice = $record['totalPrice'];
                $cur_record->describe = $record['describe'];
                $cur_record->orderId = $order->id;
                $records[] = $cur_record;

                $orderInfo.= $record['product'].',';
                $totalPrice+=$record['totalPrice'];
            }
            $order->totalPrice = $totalPrice;
            $order->orderInfo = $orderInfo;
            $order->save();
            $res = $order->records()->saveMany($records);
            if ($res) {
                return ['status' => 'success', 'info' => '插入成功！'];
            } else {
                return ['status' => 'error', 'info' => '插入失败！'];
            }
        }
    }

    /**
     * @param Request $request
     * @return array
     * 根据id删除普通订单
     */
    public function delOrdinaryOrderById(Request $request){
        if(OrdinaryOrder::destroy($request->orderId)){
            return ['status' => 'success', 'info' => '删除成功！'];
        }else{
            return ['status' => 'error', 'info' => '删除失败！'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 批量删除普通订单
     */
    public function delSelectedOrders(Request $request){
        if(OrdinaryOrder::destroy($request->orderIds)){
            return ['status' => 'success', 'info' => '删除成功！'];
        }else{
            return ['status' => 'error', 'info' => '删除失败！'];
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 获取订单信息
     */
    public function getOrderRecords(Request $request){
        return OrdinaryOrder::find($request->orderId)->records;
    }

    /**
     * @param Request $request
     * 修改普通订单
     * @return array
     */
    public function alterOrderById(Request $request){
        $order = OrdinaryOrder::find($request->orderId);
        $totalPrice = 0;
        $orderInfo = "";

        if( !empty( $request->alter_records)) {//修改记录
            foreach ($request->alter_records as $record) {
                $cur_record = OrdinaryRecord::find($record['id']);
                $cur_record->product = $record['product'];
                $cur_record->unit = $record['unit'];
                $cur_record->size = $record['size'];
                $cur_record->unitPrice = $record['unitPrice'];
                $cur_record->count = $record['count'];
                $cur_record->totalPrice = $record['totalPrice'];
                $cur_record->describe = $record['describe'];
                $cur_record->orderId = $order->id;
                $totalPrice+=$cur_record->totalPrice;
                $orderInfo.=$cur_record->product.',';
                $cur_record->save();
            }
        }

        if( !empty( $request->new_records)) {//新增记录
            foreach ($request->new_records as $record) {
                $cur_record = new OrdinaryRecord();
                $cur_record->product = $record['product'];
                $cur_record->unit = $record['unit'];
                $cur_record->size = $record['size'];
                $cur_record->unitPrice = $record['unitPrice'];
                $cur_record->count = $record['count'];
                $cur_record->totalPrice = $record['totalPrice'];
                $cur_record->describe = $record['describe'];
                $cur_record->orderId = $order->id;
                $totalPrice+=$cur_record->totalPrice;
                $orderInfo.=$cur_record->product.',';
                $records[] = $cur_record;
            }
            $order->records()->saveMany($records);
        }
        $order->totalPrice = $totalPrice;
        $order->orderInfo = $orderInfo;

        if($order->save()){
            return ['status' => 'success', 'info' => '修改成功！'];
        }else{
            return ['status' => 'error', 'info' => '修改失败！'];
        }


    }

    /**
     * @param Request $request
     * @return array
     * 删除普通订单的记录
     */
    public function delOrdinaryRecordById(Request $request){
        if(OrdinaryRecord::destroy($request->recordId)){
            return ['status' => 'success', 'info' => '删除成功！'];
        }else{
            return ['status' => 'error', 'info' => '删除失败！'];
        }
    }
    //导出所有常规订单ordinaryOrdersManage


    /**
     * @param Request $request
     * @return array
     * 修改订单完成状态
     */
    public function changeOrderStatus(Request $request){
        switch ($request->type){
            case 0:{//公司订单
                $companyRecord = CompanyRecord::find($request->orderId);
                $companyRecord->isDone = $request->isDone==0?1:0;
                if($companyRecord->save()){
                    return ['status' => 'success','info' => '修改成功！'];
                }else{
                    return ['status' => 'error','info' => '修改失败！'];
                }
            };
            case 1:{//个人订单
                $clientRecord = ClientRecord::find($request->orderId);
                $clientRecord->isDone = $request->isDone==0?1:0;
                if($clientRecord->save()){
                    return ['status' => 'success','info' => '修改成功！'];
                }else{
                    return ['status' => 'error','info' => '修改失败！'];
                }
            };
            case 2:{//普通订单
                $ordinaryOrder = OrdinaryOrder::find($request->orderId);
                $ordinaryOrder->isDone = $request->isDone==0?1:0;
                if($ordinaryOrder->save()){
                    return ['status' => 'success','info' => '修改成功！'];
                }else{
                    return ['status' => 'error','info' => '修改失败！'];
                }
            };
        }
    }
}
