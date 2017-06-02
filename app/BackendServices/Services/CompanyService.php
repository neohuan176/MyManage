<?php

/**
 * Created by PhpStorm.
 * User: a8042
 * Date: 2017/6/1 0001
 * Time: 11:17
 */
namespace App\BackendServices\Services;

use App\Client;
use App\ClientRecord;
use App\Company;
use App\CompanyRecord;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CompanyService
{
    public function __construct()
    {
    }

    /**
     * @param $companyId
     * @internal param $courseId 导出订单数据* 导出订单数据
     */
    public function exportOrderExcelByCompanyId($companyId){
        $company = Company::find($companyId);
        $companyRecords = CompanyRecord::where('companyId' , $companyId)->get();
        $Data = array();
        //处理表头
        $Data[0][0] = "订单编号";
        $Data[0][1] = "货物名称";
        $Data[0][2] = "单位";
        $Data[0][3] = "单价";
        $Data[0][4] = "数量";
        $Data[0][5] = "总价";
        $Data[0][6] = "时间";
        $Data[0][7] = "备注";
        $i = 1;
        foreach($companyRecords as $record){
            //添加姓名学号
            $Data[$i][0] = $record->_number;//考勤表专业列
            $Data[$i][1] = $record->product;//
            $Data[$i][2] = $record->unit;//
            $Data[$i][3] = $record->unitPrice;//
            $Data[$i][4] = $record->count;//
            $Data[$i][5] = $record->totalPrice;//
            $Data[$i][6] = $record->time;//
            $Data[$i][7] = $record->describe;//
            $i++;//记录是第几行记录
        }
        Excel::create($company->company.'购买记录',function($excel) use ($Data){
            $excel->sheet('record', function($sheet) use ($Data){
                $sheet->rows($Data);
            });
        })->export('xls');
    }


    /**
     * @param $clientId
     * @internal param $courseId 导出订单数据* 导出订单数据
     */
    public function exportOrderExcelByClientId($clientId){
        $client = Client::find($clientId);
        $clientRecords = ClientRecord::where('clientId' , $clientId)->get();
        $Data = array();
        //处理表头
        $Data[0][0] = "订单编号";
        $Data[0][1] = "货物名称";
        $Data[0][2] = "单位";
        $Data[0][3] = "规格尺寸";
        $Data[0][4] = "单价";
        $Data[0][5] = "数量";
        $Data[0][6] = "总价";
        $Data[0][7] = "时间";
        $Data[0][8] = "备注";
        $i = 1;
        foreach($clientRecords as $record){
            //添加姓名学号
            $Data[$i][0] = $record->_number;//考勤表专业列
            $Data[$i][1] = $record->product;//
            $Data[$i][2] = $record->unit;//
            $Data[$i][3] = $record->size;//
            $Data[$i][4] = $record->unitPrice;//
            $Data[$i][5] = $record->count;//
            $Data[$i][6] = $record->totalPrice;//
            $Data[$i][7] = $record->time;//
            $Data[$i][8] = $record->describe;//
            $i++;//记录是第几行记录
        }
        Excel::create($client->name.'购买记录',function($excel) use ($Data){
            $excel->sheet('record', function($sheet) use ($Data){
                $sheet->rows($Data);
            });
        })->export('xls');
    }


}