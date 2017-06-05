<?php

namespace App\Http\Controllers\Backend;

use App\BackendServices\Interfaces\CreatorInterface;
use App\Client;
use App\ClientRecord;
use App\Facade\exportExcelServiceFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\BackendServices\Creator\CompanyCreator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;//先用着公司客户的添加修改

class PersonalClientController extends Controller implements CreatorInterface
{
    protected $_response;
    protected $paginate = 10;
    protected $clientCreator;
    public function __construct(CompanyCreator $clientCreator)
    {
        $this->clientCreator = $clientCreator;
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return $this
     * 根据类型查找客户
     */
    public function personalClientManage(Request $request){
        $paginate = 10;
        $type = $request->has('type')?$request->get('type'):1;
        $searchInput = "";
        if($request->has('searchInput')){
            $searchInput = $request->get('searchInput');
        }
        switch ($type){
            case 1:$clients = Client::paginate($paginate);break;//查找全部
            case 2:$clients = Client::where('name','like','%'.$searchInput.'%')->paginate($paginate);break;//按照姓名查找
            case 3:$clients = Client::where('phone','like','%'.$searchInput.'%')->paginate($paginate);break;//按照电话
            case 4:$clients = Client::where('address','like','%'.$searchInput.'%')->paginate($paginate);break;//按照详细地址
        }
        return view('backend.personalClient.personalClientManage')->with(['clients'=>$clients,'type'=>$type,'searchInput'=>$searchInput]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 添加修改客户
     */
    public function addPersonalClient(Request $request){
        Log::info($request->get('clientId'));
        $clientId = $request->get('clientId');
        if($clientId == ""){//新增
            $this->_response = $this->clientCreator->createPersonalClient($this,$request);
            return response()->json($this->_response);
        }else{//修改
            $this->_response = $this->clientCreator->updatePersonalClient($this,$request);
            return response()->json($this->_response);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 根据id删除客户信息
     */
    public function deletePersonalClient(Request $request){
        if(Client::destroy($request->route("clientId"))){
            return response()->json(['status'=>'success','info' => "删除成功！"]);
        }else{
            return response()->json(['status'=>'error','info' => "删除失败！"]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 根据客户显示订单
     */
    public function showOrderByPersonalClient(Request $request){
        $clientId = $request->clientId;
        Log::info('客户id-----------'.$clientId);
        $client = Client::find($clientId);
        $orders = ClientRecord::where('clientId',$clientId)->orderBy('time','desc')->paginate($this->paginate);
        return view('backend.personalClient.showOrderByPersonalClient',['orders'=>$orders,'client' => $client]);
    }


    /**
     * @param Request $request
     * @return array
     * 添加订单
     */
    public function addClientRecord(Request $request){
        $records = $request->records;
        if(DB::table('client_records')->insert($records)){
            return ['status' => 'success','info' => '插入成功！'];
        }else{
            return ['status' => 'error','info' => '插入失败！'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 根据id删除记录
     */
    public function delRecordById(Request $request){
        if(ClientRecord::destroy($request->route('recordId'))){
            return ['status' => 'success','info' => '删除成功！'];
        }else{
            return ['status' => 'error','info' => '删除失败！'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 根据id修改记录
     */
    public function alterRecordById(Request $request){
        $record = ClientRecord::find($request->recordId);
        $record->product = $request->product;
        $record->unit = $request->unit;
        $record->size = $request->size;
        $record->unitPrice = $request->unitPrice;
        $record->count = $request->count;
        $record->totalPrice = $request->totalPrice;
        $record->describe = $request->describe;
        $record->isDone = $request->isDone;
        if($record->save()){
            return ['status' => 'success','info' => '修改成功！'];
        }else{
            return ['status' => 'error','info' => '修改失败！'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 批量删除
     */
    public function delSelectedRecord(Request $request){
        if(ClientRecord::destroy($request->items)){
            return ['status' => 'success','info' => '删除成功！'];
        }else{
            return ['status' => 'error','info' => '删除失败！'];
        }
    }


    /**
     * @param Request $request
     * 导出订单记录数据
     */
    public function exportClientRecordToExcel(Request $request){
        exportExcelServiceFacade::exportOrderExcelByClientId($request->route('clientId'));
    }

    /**
     * @param Request $request
     * @return $this
     * 显示公司客户详细信息（主要导航）
     */
    public function showClientInfo(Request $request){
        $client = Client::find($request->clientId);
        return view('backend.personalClient.showClientInfo')->with(["client" => $client]);
    }

    /**
     * @param Request $request
     * @return array
     * 获取个人客户信息
     */
    public function getClientInfo(Request $request){
        $client = Client::find($request->clientId);
        return ["client" => $client];
    }

    /**
     * @param Request $request
     * @return array
     * 修改订单完成状态
     */
    public function changeOrderStatus(Request $request){
        $clientRecord = ClientRecord::find($request->orderId);
        $clientRecord->isDone = $request->isDone==0?1:0;
        if($clientRecord->save()){
            return ['status' => 'success','info' => '修改成功！'];
        }else{
            return ['status' => 'error','info' => '修改失败！'];
        }
    }

    public function creatorFail($error)
    {
        // TODO: Implement creatorFail() method.
        return $this->_response = ['status' => 'error', 'info' => $error];
    }

    public function creatorSuccess($model)
    {
        // TODO: Implement creatorSuccess() method.
        return $this->_response = ['status' => 'success', 'info' => '操作成功'];
    }
}
