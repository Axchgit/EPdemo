<?php

namespace app\model;

use think\Model;
use app\model\Staff as StaffModel;
use think\facade\Request;
use think\facade\View;

class StaffLogin extends Model{

    public function staffRegister(){

        if(isset($_POST['submit'])){

            $post = Request::param();
            halt($post);

        }

        return View::fetch('staff_register');


    }



    //结束
}