<?php

/**
 * Created by PhpStorm.
 * User: a8042
 * Date: 2017/5/28 0028
 * Time: 16:16
 */
namespace App\BackendServices\Creator;
use App\BackendServices\Interfaces\CreatorInterface;
use App\Client;
use App\Company;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyCreator
{
    protected $_error = "error";
    function __construct()
    {
    }


    public function createPersonalClient(CreatorInterface $observer,Request $request)
    {
        $client = new Client();
        $client = $this->transformClient($client, $request);
        if (!$client) {
            return  $observer->creatorFail($this->_error);
        }
        return $observer->creatorSuccess($client);
    }

    public function updatePersonalClient(CreatorInterface $observer,Request $request){
        $client = Client::find($request->clientId);
        $client = $this->transformClient($client,$request);
        if (!$client) {
            return  $observer->creatorFail($this->_error);
        }
        return $observer->creatorSuccess($client);
    }



    public function create(CreatorInterface $observer,Request $request)
    {
        $company = new Company();
        $company = $this->transform($company, $request);
        if (!$company) {
           return  $observer->creatorFail($this->_error);
        }
        return $observer->creatorSuccess($company);
    }

    public function update(CreatorInterface $observer,Request $request){
        $company = Company::find($request->companyId);
        $company = $this->transform($company,$request);
        if (!$company) {
            return  $observer->creatorFail($this->_error);
        }
        return $observer->creatorSuccess($company);
    }

    //公司客户保存
    public function transform(Company $company, Request $request)
    {
        $company->adminId = Auth::id();
        $company->company = $request->company;
        $company->name = $request->name;
        $company->connectType = $request->connectType;
        $company->phone = $request->phone;
        $company->mobilePhone = $request->mobilePhone;
        $company->fax = $request->fax;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->address = $request->address;
        $company->describe = $request->describe;

        if($request->get("companyId")!= ""){
            if($company->position != $request->position){
                $company->position = $request->position;
                $company->lng = $request->lng;
                $company->lat = $request->lat;
            }
        }else{
            $company->position = $request->position;
            $company->lng = $request->lng;
            $company->lat = $request->lat;
        }
        try {
            $company->save();
            return $company;
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                $this->_error = '公司插入失败，flag重复了。';
            }else{
                $this->_error  = '操作失败';
            }
            return null;
        }
    }

    //个人客户保存
    public function transformClient(Client $client, Request $request)
    {
        $client->adminId = Auth::id();
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->sex = $request->sex;
        $client->fax = $request->fax;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->describe = $request->describe;

        if($request->get("clientId")!= "" && $client->position != $request->position){
            $client->position = $request->position;
            $client->lng = $request->lng;
            $client->lat = $request->lat;
        }else{
            $client->position = $request->position;
            $client->lng = $request->lng;
            $client->lat = $request->lat;
        }
        try {
            $client->save();
            return $client;
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                $this->_error = '客户插入失败，flag重复了。';
            }else{
                $this->_error  = $exception->errorInfo;
            }
            return null;
        }
    }



}