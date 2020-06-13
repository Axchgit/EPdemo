<?php
namespace app\controller;

use app\BaseController;
use think\cotroller;
use think\facade\Session;
use think\facade\View;


class AdminBase extends BaseController {

    protected function initialize() {
        // view('index');
        
        // return $this->redirect('Index/staffLogin');
        $this -> error('你还没有登陆，请登录','Index/staffLogin');

        
    }

    public function test(){
        halt('23421321');
    }






    //over
}