<?php
namespace app\controller;

use app\BaseController;
use think\cotroller;
use think\facade\Session;
use think\facade\View;


class AdminBase extends BaseController {

    protected function initialize() {
        $session = Session::all();
        if (empty($session)) {
            $this->error('你还没有登陆，请登录');
        } elseif($session['part'] != 'admin'){
            $this->error('请使用管理员账户登录');

        }
        // elseif ($session['account_status'] == 2) {
        //     $this->error('你的账户还未激活，请先激活', 'Index/StaffLoginActivation');
        // }
        // return $this->redirect('Index/staffLogin');
        // view('index');
        
        // return $this->redirect('Index/staffLogin');
        // $this -> error('你还没有登陆，请登录','Index/staffLogin');

        
    }

    public function test(){
        halt('23421321');
    }






    //over
}