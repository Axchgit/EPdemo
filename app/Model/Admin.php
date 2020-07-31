<?php

namespace app\model;

use PHPExcel_IOFactory;
use think\Model;
use think\facade\Db;


class Admin extends Model
{
    public function adminLoginCheck($email,$password)
    {
        return $this->where('email',$email)->where('password',$password)->find();
    }
}
