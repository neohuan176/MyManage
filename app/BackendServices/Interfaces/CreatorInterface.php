<?php
/**
 * Created by PhpStorm.
 * User: a8042
 * Date: 2017/5/28 0028
 * Time: 17:02
 */

namespace App\BackendServices\Interfaces;


interface CreatorInterface
{
    public function creatorFail($error);
    public function creatorSuccess($model);
}