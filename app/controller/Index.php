<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Request;
use app\model\Staff as StaffModel;
use app\model\StaffLogin as StaffLoginModel;

class Index extends BaseController
{



    public function staffRegister(){
        
        $post = Request::param();

        if(isset($post['submit'])){

            $is_has = StaffLoginModel::where('work_num',$post['work_num'])->where('staff_review_status',1)->find();
            if(isset($is_has)){
                return '账户已存在';
            }

            $staff_login = new StaffLoginModel();

            $staff_login->save([
                'work_num' => $post['work_num'],
                'nickname' => $post['nickname'],
                'password' => $post['password'],
                'short_introduce' => $post['short_introduce']


            ]);



            // halt($post['goods_id']);
            

        }

        return View::fetch('staff_register');


    }






    public function index()
    {
        return View::fetch('index');
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
    public function login()
    {
        $name = $_POST['logname'];
        echo $name;
        return 123;
    }
}
