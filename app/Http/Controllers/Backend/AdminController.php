<?php

namespace App\Http\Controllers\Backend;

use App\BackendServices\Creator\CompanyCreator;
use App\BackendServices\Interfaces\CreatorInterface;
use App\Company;
use App\CompanyRecord;
use App\Facade\CompanyServiceFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller implements CreatorInterface
{
    protected $companyCreator;
    protected $_response = [];
    protected $paginate = 10;
    public function __construct( CompanyCreator $companyCreator )
    {
        $this->companyCreator = $companyCreator;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 后台首页
     */
    public function index(){
        Log::info("进入=================");
        return view('backend.index');
    }


    /**
     * @param Request $request
     * @return $this
     * 根据类型查找公司
     */
    public function companyManage(Request $request){
        $paginate = 5;
        $type = $request->has('type')?$request->get('type'):1;
        $searchInput = "";
        if($request->has('searchInput')){
            $searchInput = $request->get('searchInput');
        }
        switch ($type){
            case 1:$companies = Company::paginate($paginate);break;//查找全部
            case 2:$companies = Company::where('company','like','%'.$searchInput.'%')->paginate($paginate);break;//按照公司查找
            case 3:$companies = Company::where('name','like','%'.$searchInput.'%')->paginate($paginate);break;//按照
            case 4:$companies = Company::where('mobilePhone','like','%'.$searchInput.'%')->paginate($paginate);break;//按照
        }
        return view('backend.companyManage')->with(['companies'=>$companies,'type'=>$type,'searchInput'=>$searchInput]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 添加修改公司客户
     */
    public function addCompany(Request $request){
        Log::info($request->get('companyId'));
        $companyId = $request->get('companyId');
        if($companyId == ""){//新增
            $this->_response = $this->companyCreator->create($this,$request);
            return response()->json($this->_response);
        }else{//修改
            $this->_response = $this->companyCreator->update($this,$request);
            return response()->json($this->_response);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 根据id删除公司客户信息
     */
    public function deleteCompany(Request $request){
        if(Company::destroy($request->route("companyId"))){
            return response()->json(['status'=>'success','info' => "删除成功！"]);
        }else{
            return response()->json(['status'=>'error','info' => "删除失败！"]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 根据公司显示订单
     */
    public function showOrderByCompany(Request $request){
        $companyId = $request->companyId;
        $company = Company::find($companyId);
        $orders = CompanyRecord::where('companyId',$companyId)->orderBy('time','desc')->paginate($this->paginate);
        return view('backend.showOrderByCompany',['orders'=>$orders,'company' => $company]);
    }


    /**
     * @param Request $request
     * @return array
     * 添加订单
     */
    public function addCompanyRecord(Request $request){
        $records = $request->records;
        if(DB::table('company_records')->insert($records)){
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
        if(CompanyRecord::destroy($request->route('recordId'))){
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
        $record = CompanyRecord::find($request->recordId);
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
        if(CompanyRecord::destroy($request->items)){
            return ['status' => 'success','info' => '删除成功！'];
        }else{
            return ['status' => 'error','info' => '删除失败！'];
        }
    }


    /**
     * @param Request $request
     * 导出订单记录数据
     */
    public function exportCompanyToExcel(Request $request){
        CompanyServiceFacade::exportOrderExcelByCompanyId($request->route('companyId'));
    }

    /**
     * @param Request $request
     * @return $this
     * 显示公司客户详细信息（主要导航）
     */
    public function showCompanyInfo(Request $request){
        $company = Company::find($request->companyId);
        return view('backend.showCompanyInfo')->with(["company" => $company]);
    }

    /**
     * @param Request $request
     * @return array
     * 获取公司详细信息？ 需要修改
     */
    public function getDataTest(Request $request){
        $company = Company::find($request->companyId);
        return ["company" => $company];
    }

    /**
     * @param Request $request
     * @return array
     * 修改订单完成状态
     */
    public function changeOrderStatus(Request $request){
        $companyRecord = CompanyRecord::find($request->orderId);
        $companyRecord->isDone = $request->isDone==0?1:0;
        if($companyRecord->save()){
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
