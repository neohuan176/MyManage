<?php
namespace App\Facade;
/**
 * Created by PhpStorm.
 * User: a8042
 * Date: 2017/6/1 0001
 * Time: 11:28
 */
use Illuminate\Support\Facades\Facade;
class CompanyServiceFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'companyService'; }
}